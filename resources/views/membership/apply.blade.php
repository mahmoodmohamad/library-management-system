@extends('layouts.app')

@section('title', 'Apply for membership')

@section('content')
<div class="mx-auto max-w-2xl">

    <h1 class="text-2xl font-bold text-slate-900">Apply for membership</h1>
    <p class="mt-1 text-sm text-slate-500">
        Fill in your details. The library will review your application before you can borrow books.
    </p>

    @if ($application?->status === 'pending')
        <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            Your application is pending review. You can update your details below.
        </div>
    @elseif ($application?->status === 'rejected')
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            Your previous application was not approved. You can update your details and apply again.
        </div>
    @endif

    <form method="POST" action="{{ route('membership.apply.store') }}" class="mt-8 space-y-5">
        @csrf

        @php
            $fields = [
                'phone' => ['Phone', 'tel'],
                'date_of_birth' => ['Date of birth', 'date'],
                'emergency_contact_name' => ['Emergency contact name', 'text'],
                'emergency_contact_phone' => ['Emergency contact phone', 'tel'],
            ];
        @endphp

        @foreach ($fields as $name => [$label, $type])
            <div>
                <label for="{{ $name }}" class="mb-2 block text-sm font-medium text-slate-700">{{ $label }}</label>
                <input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}"
                       value="{{ old($name, $application?->{$name} instanceof \DateTimeInterface ? $application->{$name}->format('Y-m-d') : $application?->{$name}) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-100">
            </div>
        @endforeach

        <div>
            <label for="address" class="mb-2 block text-sm font-medium text-slate-700">Address</label>
            <textarea id="address" name="address" rows="3"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-100">{{ old('address', $application?->address) }}</textarea>
        </div>

        <button type="submit"
                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
            {{ $application ? 'Update application' : 'Submit application' }}
        </button>
    </form>
</div>
@endsection