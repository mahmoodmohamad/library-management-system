<?php

namespace App\Http\Controllers;

use App\Models\MembershipApplication;
use Illuminate\Http\Request;

class MembershipApplicationController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        if ($user->member) {
            return redirect()->route('profile');
        }

        return view('membership.apply', [
            'application' => $user->membershipApplication,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->member) {
            return redirect()->route('profile');
        }

        $data = $request->validate([
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'date_of_birth' => 'required|date|before:today',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:255',
        ]);

        MembershipApplication::updateOrCreate(
            ['user_id' => $user->id],
            $data + ['status' => 'pending']
        );

        return redirect()->route('profile')
            ->with('success', 'Application submitted. The library will review it shortly.');
    }
}