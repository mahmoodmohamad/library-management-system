{{-- resources/views/admin/members/form.blade.php --}}
@extends('layouts.admin')

@section('title', $member->exists ? 'Edit Member' : 'Add Member')
@section('page-title', $member->exists ? 'Edit Member' : 'Add Member')
@section('page-description', $member->exists
    ? 'Update member details and membership status'
    : 'Register a new library member')

@section('content')

<form method="POST"
      action="{{ $member->exists ? route('admin.members.update', $member) : route('admin.members.store') }}"
      class="max-w-5xl"
      novalidate
      onsubmit="this.querySelector('[type=submit]').disabled = true">

    @csrf
    @isset($application)
    <input type="hidden" name="application_id" value="{{ $application->id }}">
@endisset
    @if ($member->exists) @method('PUT') @endif

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
            Fix {{ $errors->count() }} {{ Str::plural('error', $errors->count()) }} below and save again.
        </div>
    @endif


    {{-- Personal details --}}
    <section class="grid gap-6 border-b border-slate-200 pb-10 lg:grid-cols-3 lg:gap-10">
        <div>
            <h2 class="text-sm font-semibold text-slate-900">Personal details</h2>
            <p class="mt-1 text-sm text-slate-500">How the member is identified and contacted.</p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:col-span-2">
            <x-form.field name="first_name" label="First name" :value="$member->first_name" autocomplete="off" required />
            <x-form.field name="last_name" label="Last name" :value="$member->last_name" autocomplete="off" required />

            <x-form.field name="email" label="Email" type="email" :value="$member->email" required
                          hint="Members sign in with this email. Changing it unlinks their account."
                          class="sm:col-span-2" />

            <x-form.field name="phone" label="Phone" type="tel" inputmode="tel" :value="$member->phone" required />
            <x-form.field name="date_of_birth" label="Date of birth" type="date"
                          :value="$member->date_of_birth" max="{{ now()->subDay()->toDateString() }}" required />

            <x-form.field name="address" label="Address" type="textarea" :value="$member->address" required
                          class="sm:col-span-2" />
        </div>
    </section>


    {{-- Membership --}}
    <section class="grid gap-6 border-b border-slate-200 py-10 lg:grid-cols-3 lg:gap-10">
        <div>
            <h2 class="text-sm font-semibold text-slate-900">Membership</h2>
            <p class="mt-1 text-sm text-slate-500">Type, validity period and borrowing eligibility.</p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:col-span-2">
            <x-form.field name="member_number" label="Member number" :value="$member->member_number" required />

            <x-form.field name="membership_type" label="Type" type="select" required
                          :value="$member->membership_type"
                          :options="['student' => 'Student', 'teacher' => 'Teacher', 'staff' => 'Staff', 'public' => 'Public']" />

            <x-form.field name="membership_start_date" label="Start date" type="date"
                          :value="$member->membership_start_date" required />
            <x-form.field name="membership_expiry_date" label="Expiry date" type="date"
                          :value="$member->membership_expiry_date" required />

            <x-form.field name="status" label="Status" type="select" required
                          :value="$member->status ?? 'active'"
                          :options="['active' => 'Active', 'suspended' => 'Suspended', 'expired' => 'Expired']"
                          hint="Only active members can borrow books." />

            <x-form.field name="outstanding_fines" label="Outstanding fines" type="number"
                          :value="$member->outstanding_fines ?? 0" step="0.01" min="0" inputmode="decimal" />
        </div>
    </section>


    {{-- Emergency contact --}}
    <section class="grid gap-6 border-b border-slate-200 py-10 lg:grid-cols-3 lg:gap-10">
        <div>
            <h2 class="text-sm font-semibold text-slate-900">Emergency contact</h2>
            <p class="mt-1 text-sm text-slate-500">Who to call if the library cannot reach the member.</p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:col-span-2">
            <x-form.field name="emergency_contact_name" label="Contact name"
                          :value="$member->emergency_contact_name" required />
            <x-form.field name="emergency_contact_phone" label="Contact phone" type="tel" inputmode="tel"
                          :value="$member->emergency_contact_phone" required />
        </div>
    </section>


    {{-- Notes --}}
    <section class="grid gap-6 py-10 lg:grid-cols-3 lg:gap-10">
        <div>
            <h2 class="text-sm font-semibold text-slate-900">Notes</h2>
            <p class="mt-1 text-sm text-slate-500">Visible to staff only.</p>
        </div>

        <div class="lg:col-span-2">
            <x-form.field name="notes" label="Internal notes" type="textarea" :value="$member->notes" />
        </div>
    </section>


    {{-- Actions --}}
    <div class="sticky bottom-0 -mx-4 flex items-center justify-end gap-3 border-t border-slate-200
                bg-white/95 px-4 py-4 backdrop-blur sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">

        <a href="{{ $member->exists ? route('admin.members.show', $member) : route('admin.members.index') }}"
           class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700
                  hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300">
            Cancel
        </a>

        <button type="submit"
                class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700
                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                       disabled:cursor-not-allowed disabled:opacity-60">
            {{ $member->exists ? 'Save changes' : 'Add member' }}
        </button>
    </div>

</form>

@endsection