@extends('layouts.admin')

@section('title', 'Membership requests')
@section('page-title', 'Membership requests')
@section('page-description', 'Registered users waiting to become members')

@section('content')
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">User</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Registered</th>
                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
    @forelse ($applications as $a)
        <tr class="hover:bg-slate-50">
            <td class="px-6 py-4">
                <p class="font-semibold text-slate-900">{{ $a->user->name }}</p>
                <p class="text-xs text-slate-500">{{ $a->user->email }} · {{ $a->phone }}</p>
            </td>
            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                {{ $a->created_at->toDateString() }}
            </td>
            <td class="px-6 py-4">
                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.members.create', ['application' => $a->id]) }}"
                       class="rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">
                        Review
                    </a>
                    <form method="POST" action="{{ route('admin.members.applications.reject', $a) }}"
                          onsubmit="return confirm('Reject this application?')">
                        @csrf
                        <button class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                            Reject
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="px-6 py-12 text-center text-sm text-slate-500">No pending applications.</td>
        </tr>
    @endforelse
</tbody>
    </table>

@if ($applications->hasPages())
    <div class="border-t border-slate-200 px-6 py-4">
        {{ $applications->links() }}
    </div>
@endif
</div>
@endsection