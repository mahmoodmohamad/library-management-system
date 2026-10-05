@extends('layouts.admin')

@section('title', 'Staff')
@section('page-title', 'Staff')
@section('page-description', 'Manage staff accounts and access to the administration area')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">
                Staff accounts
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Create and manage staff accounts.
            </p>
        </div>

        <a
            href="{{ route('admin.staff.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg
                   bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                   shadow-sm transition hover:bg-blue-700
                   focus:outline-none focus:ring-2
                   focus:ring-blue-500 focus:ring-offset-2"
        >
            <svg class="h-4 w-4"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path d="M12 5v14"/>
                <path d="M5 12h14"/>
            </svg>

            Add staff
        </a>

    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <form method="GET" action="{{ route('admin.staff.index') }}">

            <div class="flex flex-col gap-3 sm:flex-row">

                <div class="flex-1">

                    <label for="search" class="sr-only">
                        Search staff
                    </label>

                    <input
                        id="search"
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search by name or email..."
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5
                               text-sm text-slate-900 placeholder-slate-400
                               focus:border-blue-500 focus:outline-none
                               focus:ring-2 focus:ring-blue-500/20"
                    >

                </div>

                <button
                    type="submit"
                    class="rounded-lg border border-slate-300 bg-white px-4 py-2.5
                           text-sm font-medium text-slate-700
                           transition hover:bg-slate-50"
                >
                    Search
                </button>

                @if ($search)
                    <a
                        href="{{ route('admin.staff.index') }}"
                        class="inline-flex items-center justify-center rounded-lg
                               border border-slate-300 px-4 py-2.5
                               text-sm font-medium text-slate-600
                               hover:bg-slate-50"
                    >
                        Clear
                    </a>
                @endif

            </div>

        </form>

    </div>

    {{-- Staff table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-6 py-5">
            <h3 class="font-semibold text-slate-900">
                Staff
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                {{ $staff->total() }} staff account{{ $staff->total() === 1 ? '' : 's' }}
            </p>
        </div>

        @if ($staff->isEmpty())

            <div class="px-6 py-12 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                    <svg class="h-6 w-6"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M2 21a7 7 0 0 1 14 0"/>
                        <path d="M19 8v6"/>
                        <path d="M22 11h-6"/>
                    </svg>
                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    No staff accounts found
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Create a staff account to give someone access to the admin area.
                </p>

            </div>

        @else

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-100">

                    <thead class="bg-slate-50">

                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Staff
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Email
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Verification
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">

                        @foreach ($staff as $member)

                            <tr class="transition hover:bg-slate-50">

                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-50 text-sm font-semibold text-blue-700">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">
                                                {{ $member->name }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                Staff
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                    {{ $member->email }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($member->email_verified_at)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                            Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">
                                            Not verified
                                        </span>
                                    @endif

                                </td>

                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.staff.edit', $member) }}"
                                            class="rounded-lg border border-slate-200 px-3 py-1.5
                                                   text-xs font-medium text-slate-700
                                                   hover:bg-slate-50"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.staff.destroy', $member) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this staff account?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg border border-red-200 px-3 py-1.5
                                                       text-xs font-medium text-red-600
                                                       hover:bg-red-50"
                                            >
                                                Delete
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @if ($staff->hasPages())
                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $staff->links() }}
                </div>
            @endif

        @endif

    </div>

</div>

@endsection
