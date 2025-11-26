<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Show user profile page
     */
    public function profile()
    {
        $user = Auth::user();
        return view('accounts.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20'],
            'company' => ['required', 'string', 'max:255'],
        ]);

        $user->update($validated);

        return redirect()->route('accounts.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show security/change password page
     */
    public function security()
    {
        $user = Auth::user();
        return view('accounts.security', compact('user'));
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.'
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return redirect()->route('accounts.security')->with('success', 'Password changed successfully!');
    }
}