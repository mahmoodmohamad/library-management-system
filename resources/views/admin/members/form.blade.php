@extends('layouts.admin')
@section('title', $member->exists ? 'Edit member' : 'Add member')
@section('content')
<form method="POST" action="{{ $member->exists ? route('members.update', $member) : route('members.store') }}" class="card card-body">
    @csrf
    @if ($member->exists) @method('PUT') @endif
    <div class="row g-3">
        @foreach ([
            'member_number' => 'text', 'email' => 'email', 'first_name' => 'text', 'last_name' => 'text',
            'phone' => 'text', 'date_of_birth' => 'date', 'membership_start_date' => 'date', 'membership_expiry_date' => 'date',
            'emergency_contact_name' => 'text', 'emergency_contact_phone' => 'text', 'outstanding_fines' => 'number',
        ] as $name => $type)
            @php
                $value = old($name, $member->$name);
                if ($value instanceof \DateTimeInterface) { $value = $value->format('Y-m-d'); }
            @endphp
            <div class="col-md-6">
                <label class="form-label">{{ Str::headline($name) }}</label>
                <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" @if ($name === 'outstanding_fines') step="0.01" min="0" @endif class="form-control @error($name) is-invalid @enderror">
            </div>
        @endforeach
        <div class="col-md-6">
            <label class="form-label">Membership type</label>
            <select name="membership_type" class="form-select">
                @foreach (['student', 'teacher', 'staff', 'public'] as $t)
                    <option value="{{ $t }}" @selected(old('membership_type', $member->membership_type) === $t)>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach (['active', 'suspended', 'expired'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $member->status ?? 'active') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Address</label>
            <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address', $member->address) }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Notes</label>
            <textarea name="notes" rows="2" class="form-control">{{ old('notes', $member->notes) }}</textarea>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('members.index') }}" class="btn btn-link">Cancel</a>
    </div>
</form>
@endsection
