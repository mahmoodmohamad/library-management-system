{{-- resources/views/admin/members/show.blade.php --}}
@extends('layouts.admin')

@php
    $fullName = $member->first_name.' '.$member->last_name;
    $fines = (float) $member->outstanding_fines;
    $expired = $member->membership_expiry_date->isPast();
    $statusStyle = match ($member->status) {
        'active'    => 'bg-emerald-50 text-emerald-700',
        'suspended' => 'bg-amber-50 text-amber-700',
        default     => 'bg-slate-100 text-slate-600',
    };
@endphp

@section('title', $fullName)
@section('page-title', $fullName)
@section('page-description', 'Member #'.$member->member_number)

@section('content')

<div class="max-w-5xl space-y-10">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">
            <h2 class="text-xl font-bold text-slate-900">{{ $fullName }}</h2>
            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusStyle }}">
                {{ ucfirst($member->status) }}
            </span>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.members.index') }}"
               class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium
                      text-slate-700 hover:bg-slate-50">
                Back
            </a>
            <a href="{{ route('admin.members.edit', $member) }}"
               class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Edit
            </a>
        </div>

    </div>


    {{-- Details --}}
    <section class="grid gap-6 lg:grid-cols-3 lg:gap-10">

        <div>
            <h3 class="text-sm font-semibold text-slate-900">Details</h3>
            <p class="mt-1 text-sm text-slate-500">Contact, membership and emergency contact.</p>
        </div>

        <dl class="grid gap-x-8 gap-y-5 text-sm sm:grid-cols-2 lg:col-span-2">

            <div>
                <dt class="text-slate-500">Email</dt>
                <dd class="mt-1 break-all font-medium text-slate-900">{{ $member->email }}</dd>
            </div>

            <div>
                <dt class="text-slate-500">Phone</dt>
                <dd class="mt-1 font-medium text-slate-900">{{ $member->phone }}</dd>
            </div>

            <div>
                <dt class="text-slate-500">Membership type</dt>
                <dd class="mt-1 font-medium text-slate-900">{{ ucfirst($member->membership_type) }}</dd>
            </div>

            <div>
                <dt class="text-slate-500">Valid</dt>
                <dd class="mt-1 font-medium text-slate-900">
                    {{ $member->membership_start_date->toDateString() }}
                    to
                    <span class="{{ $expired ? 'text-red-600' : '' }}">
                        {{ $member->membership_expiry_date->toDateString() }}
                    </span>
                    @if ($expired)
                        <span class="font-normal text-red-600">(expired)</span>
                    @endif
                </dd>
            </div>

            <div>
                <dt class="text-slate-500">Outstanding fines</dt>
                <dd class="mt-1 font-medium {{ $fines > 0 ? 'text-red-600' : 'text-slate-900' }}">
                    {{ number_format($fines, 2) }}
                </dd>
            </div>

            <div>
                <dt class="text-slate-500">Emergency contact</dt>
                <dd class="mt-1 font-medium text-slate-900">
                    {{ $member->emergency_contact_name }}
                    <span class="font-normal text-slate-500">{{ $member->emergency_contact_phone }}</span>
                </dd>
            </div>

            <div class="sm:col-span-2">
                <dt class="text-slate-500">Address</dt>
                <dd class="mt-1 whitespace-pre-line text-slate-900">{{ $member->address }}</dd>
            </div>

            <div class="sm:col-span-2">
                <dt class="text-slate-500">Notes</dt>
                <dd class="mt-1 whitespace-pre-line {{ $member->notes ? 'text-slate-900' : 'text-slate-400' }}">
                    {{ $member->notes ?: 'No notes.' }}
                </dd>
            </div>

        </dl>

    </section>


    {{-- Borrowing history --}}
    <section>

        <h3 class="mb-4 text-sm font-semibold text-slate-900">
            Borrowing history
            <span class="font-normal text-slate-500">({{ $member->borrowings->count() }})</span>
        </h3>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">
                        <tr>
                            @foreach (['Book', 'Borrowed', 'Due', 'Returned', 'Fine'] as $th)
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase
                                           tracking-wider text-slate-500 {{ $th === 'Fine' ? 'text-right' : '' }}">
                                    {{ $th }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                    @forelse ($member->borrowings as $b)

                        @php
                            $overdue = ! $b->returned_at && $b->due_date->isPast();
                            $fine = (float) $b->fine_amount;
                        @endphp

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4 text-sm">
                                @if ($b->book)
                                    <a href="{{ route('admin.books.show', $b->book) }}"
                                       class="font-medium text-slate-900 hover:text-blue-600">
                                        {{ $b->book->title }}
                                    </a>
                                @else
                                    <span class="text-slate-400">Deleted book</span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                {{ $b->borrowed_at->toDateString() }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm
                                       {{ $overdue ? 'font-semibold text-red-600' : 'text-slate-600' }}">
                                {{ $b->due_date->toDateString() }}
                                @if ($overdue) <span class="font-normal">(overdue)</span> @endif
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                {{ $b->returned_at?->toDateString() ?? 'Not returned' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm
                                       {{ $fine > 0 ? 'font-semibold text-red-600' : 'text-slate-500' }}">
                                {{ number_format($fine, 2) }}
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="font-semibold text-slate-700">No borrowings yet</p>
                                <p class="mt-1 text-sm text-slate-500">Loans will appear here once a book is issued.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </section>

</div>

@endsection