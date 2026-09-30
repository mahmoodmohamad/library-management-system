@extends('layouts.admin')

@section('title', 'Members')
@section('page-title', 'Members')
@section('page-description', 'Manage library members')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-xl font-bold text-slate-900">
                Members
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage memberships, status and borrowing activity.
            </p>
        </div>

        <a href="{{ route('admin.members.create') }}"
           class="inline-flex items-center justify-center gap-2
                  rounded-xl bg-blue-600 px-4 py-2.5
                  text-sm font-semibold text-white shadow-sm
                  hover:bg-blue-700">

            <span class="text-lg leading-none">+</span>
            Add Member

        </a>

    </div>


    {{-- Search --}}
    <div class="rounded-2xl border border-slate-200 bg-white
                p-4 shadow-sm">

        <form method="GET" class="flex flex-col gap-3 sm:flex-row">

            <div class="relative flex-1">

                <svg class="pointer-events-none absolute left-3 top-1/2
                            h-5 w-5 -translate-y-1/2 text-slate-400"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/>

                </svg>

                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search by name, email or member number..."
                    class="w-full rounded-xl border border-slate-300
                           bg-white py-2.5 pl-10 pr-4 text-sm
                           outline-none transition
                           placeholder:text-slate-400
                           focus:border-blue-500
                           focus:ring-2 focus:ring-blue-100">

            </div>

            <button type="submit"
                    class="rounded-xl border border-slate-300
                           bg-white px-5 py-2.5 text-sm font-semibold
                           text-slate-700 hover:bg-slate-50">

                Search

            </button>

            @if(request('q'))

                <a href="{{ route('admin.members.index') }}"
                   class="rounded-xl px-4 py-2.5 text-center
                          text-sm font-medium text-slate-500
                          hover:bg-slate-50">

                    Clear

                </a>

            @endif

        </form>

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200
                bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Member
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Type
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Expires
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Fines
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Books Out
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                @forelse ($members as $m)

                    <tr class="transition hover:bg-slate-50">

                        {{-- Member --}}
                        <td class="px-6 py-4">

                            <div>

                                <a href="{{ route('admin.members.show', $m) }}"
                                   class="font-semibold text-slate-900
                                          hover:text-blue-600">

                                    {{ $m->first_name }}
                                    {{ $m->last_name }}

                                </a>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    #{{ $m->member_number }}
                                </p>

                            </div>

                        </td>


                        {{-- Type --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            <span class="text-sm text-slate-600">
                                {{ ucfirst($m->membership_type) }}
                            </span>

                        </td>


                        {{-- Status --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            @if($m->status === 'active')

                                <span class="inline-flex rounded-full
                                             bg-emerald-50 px-2.5 py-1
                                             text-xs font-semibold
                                             text-emerald-700">
                                    Active
                                </span>

                            @elseif($m->status === 'suspended')

                                <span class="inline-flex rounded-full
                                             bg-amber-50 px-2.5 py-1
                                             text-xs font-semibold
                                             text-amber-700">
                                    Suspended
                                </span>

                            @else

                                <span class="inline-flex rounded-full
                                             bg-slate-100 px-2.5 py-1
                                             text-xs font-semibold
                                             text-slate-600">
                                    {{ ucfirst($m->status) }}
                                </span>

                            @endif

                        </td>


                        {{-- Expiry --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                            {{ $m->membership_expiry_date?->toDateString() ?? '—' }}

                        </td>


                        {{-- Fines --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            @if((float) $m->outstanding_fines > 0)

                                <span class="font-semibold text-red-600">
                                    {{ number_format((float) $m->outstanding_fines, 2) }}
                                </span>

                            @else

                                <span class="text-sm text-slate-500">
                                    0.00
                                </span>

                            @endif

                        </td>


                        {{-- Books out --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            <span class="inline-flex min-w-8 justify-center
                                         rounded-lg bg-slate-100 px-2 py-1
                                         text-xs font-semibold text-slate-700">

                                {{ $m->active_borrowings_count }}

                            </span>

                        </td>


                        {{-- Actions --}}
                        <td class="whitespace-nowrap px-6 py-4 text-right">

                            <div class="flex justify-end gap-2">

                                <a href="{{ route('admin.members.edit', $m) }}"
                                   class="rounded-lg border border-slate-300
                                          px-3 py-1.5 text-xs font-semibold
                                          text-slate-700 hover:bg-slate-50">

                                    Edit

                                </a>

                                <form method="POST"
                                      action="{{ route('admin.members.destroy', $m) }}"
                                      onsubmit="return confirm('Delete this member?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-lg border border-red-200
                                                   px-3 py-1.5 text-xs font-semibold
                                                   text-red-600 hover:bg-red-50">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="px-6 py-12 text-center">

                            <p class="font-semibold text-slate-700">
                                No members found
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Try changing your search or add a new member.
                            </p>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($members->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $members->withQueryString()->links() }}
            </div>

        @endif

    </div>

</div>

@endsection