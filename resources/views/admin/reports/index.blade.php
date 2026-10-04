@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Reports')
@section('page-description', 'Borrowing activity and fines')

@section('content')

<div class="max-w-5xl space-y-10">

    <form method="GET" class="flex flex-wrap items-end gap-3">
        <div>
            <label for="from" class="mb-1.5 block text-sm font-medium text-slate-700">From</label>
            <input id="from" type="date" name="from" value="{{ $from }}"
                   class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>
        <div>
            <label for="to" class="mb-1.5 block text-sm font-medium text-slate-700">To</label>
            <input id="to" type="date" name="to" value="{{ $to }}"
                   class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
        </div>
        <button type="submit"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            Apply
        </button>
        @error('to') <p class="w-full text-xs text-red-600">{{ $message }}</p> @enderror
    </form>

    <section>
        <h2 class="text-sm font-semibold text-slate-900">In selected period</h2>
        <dl class="mt-4 grid gap-x-10 sm:grid-cols-3">
            @foreach ([
                'Books borrowed' => number_format($stats['borrowed']),
                'Books returned' => number_format($stats['returned']),
                'Fines charged'  => number_format($stats['fines_charged'], 2),
            ] as $label => $value)
                <div class="border-b border-slate-100 py-4">
                    <dt class="text-sm text-slate-500">{{ $label }}</dt>
                    <dd class="mt-1 text-2xl font-semibold tabular-nums text-slate-900">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    <section>
        <h2 class="text-sm font-semibold text-slate-900">Right now</h2>
        <dl class="mt-4 grid gap-x-10 sm:grid-cols-3">
            <div class="border-b border-slate-100 py-4">
                <dt class="text-sm text-slate-500">Overdue books</dt>
                <dd class="mt-1 text-2xl font-semibold tabular-nums {{ $stats['overdue_now'] > 0 ? 'text-red-600' : 'text-slate-900' }}">
                    {{ number_format($stats['overdue_now']) }}
                </dd>
            </div>
            <div class="border-b border-slate-100 py-4">
                <dt class="text-sm text-slate-500">Outstanding fines</dt>
                <dd class="mt-1 text-2xl font-semibold tabular-nums text-slate-900">
                    {{ number_format($stats['fines_outstanding'], 2) }}
                </dd>
            </div>
        </dl>
    </section>

</div>

@endsection