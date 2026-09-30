@extends('layouts.admin')
@section('title', $member->first_name.' '.$member->last_name)
@section('content')
<div class="card mb-3"><div class="card-body">
    <dl class="row mb-0">
        <dt class="col-sm-3">Member number</dt><dd class="col-sm-9">{{ $member->member_number }}</dd>
        <dt class="col-sm-3">Email / Phone</dt><dd class="col-sm-9">{{ $member->email }} / {{ $member->phone }}</dd>
        <dt class="col-sm-3">Type</dt><dd class="col-sm-9">{{ ucfirst($member->membership_type) }}</dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ $member->status }}</dd>
        <dt class="col-sm-3">Membership</dt><dd class="col-sm-9">{{ $member->membership_start_date->toDateString() }} to {{ $member->membership_expiry_date->toDateString() }}</dd>
        <dt class="col-sm-3">Outstanding fines</dt><dd class="col-sm-9">{{ $member->outstanding_fines }}</dd>
        <dt class="col-sm-3">Emergency contact</dt><dd class="col-sm-9">{{ $member->emergency_contact_name }} ({{ $member->emergency_contact_phone }})</dd>
        <dt class="col-sm-3">Notes</dt><dd class="col-sm-9">{{ $member->notes ?: '-' }}</dd>
    </dl>
</div></div>
<h2 class="h5">Borrowing history</h2>
<table class="table table-sm bg-white">
    <thead><tr><th>Book</th><th>Borrowed</th><th>Due</th><th>Returned</th><th>Fine</th></tr></thead>
    <tbody>
    @forelse ($member->borrowings as $b)
        <tr>
            <td>{{ $b->book?->title }}</td>
            <td>{{ $b->borrowed_at->toDateString() }}</td>
            <td>{{ $b->due_date->toDateString() }}</td>
            <td>{{ $b->returned_at?->toDateString() ?: '-' }}</td>
            <td>{{ $b->fine_amount }}</td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-muted text-center">No borrowings yet.</td></tr>
    @endforelse
    </tbody>
</table>
<a href="{{ route('members.edit', $member) }}" class="btn btn-primary">Edit</a>
<a href="{{ route('members.index') }}" class="btn btn-link">Back</a>
@endsection
