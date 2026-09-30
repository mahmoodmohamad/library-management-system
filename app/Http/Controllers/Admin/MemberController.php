<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::withCount(['borrowings as active_borrowings_count' => fn ($q) => $q->whereNull('returned_at')])
            ->when($request->q, fn ($query, $s) => $query->where(
                fn ($w) => $w->where('first_name', 'like', "%{$s}%")
                    ->orWhere('last_name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('member_number', 'like', "%{$s}%")
            ))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return $request->expectsJson() ? $members : view('admin.members.index', compact('members'));
    }

    public function show(Request $request, Member $member)
    {
        $member->load(['borrowings' => fn ($q) => $q->with('book')->latest('borrowed_at')]);

        return $request->expectsJson() ? $member : view('admin.members.show', compact('member'));
    }

    public function create()
    {
        return view('admin.members.form', ['member' => new Member()]);
    }

    public function edit(Member $member)
    {
        return view('admin.members.form', compact('member'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['outstanding_fines'] ??= 0;

        $member = Member::create($data);

        if ($request->expectsJson()) {
            return response()->json($member, 201);
        }

        return redirect()->route('admin.members.show', $member)->with('success', 'Member created.');
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate($this->rules($member));
        $data['outstanding_fines'] ??= 0;

        $member->update($data);

        if ($request->expectsJson()) {
            return $member->fresh();
        }

        return redirect()->route('admin.members.show', $member)->with('success', 'Member updated.');
    }

    public function destroy(Request $request, Member $member)
    {
        if ($member->borrowings()->whereNull('returned_at')->exists()) {
            throw ValidationException::withMessages([
                'member' => 'This member still has borrowed books.',
            ]);
        }

        $member->delete();

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('admin.members.index')->with('success', 'Member deleted.');
    }

    private function rules(?Member $member = null): array
    {
        return [
            'member_number' => ['required', 'string', 'max:255', Rule::unique('members', 'member_number')->ignore($member)],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('members', 'email')->ignore($member)],
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'date_of_birth' => 'required|date|before:today',
            'membership_type' => ['required', Rule::in(['student', 'teacher', 'staff', 'public'])],
            'membership_start_date' => 'required|date',
            'membership_expiry_date' => 'required|date|after:membership_start_date',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:255',
            'status' => ['required', Rule::in(['active', 'suspended', 'expired'])],
            'outstanding_fines' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }
}
