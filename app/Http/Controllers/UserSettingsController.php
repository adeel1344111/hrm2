<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserSettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Manual check for plain text password
        if ($user->password !== $request->current_password) {
            return redirect()->back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        // Update password
        $user->update([
            'password' => $request->new_password,
        ]);

        return redirect()->route('settings.index')->with('success', 'Password updated successfully.');
    }

    /**
     * Update profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'dob' => 'required|date|before:today',
        ]);

        $user->update([
            'dob' => $request->dob,
        ]);

        return redirect()->route('settings.index')->with('success', 'Date of birth updated successfully.');
    }
}
