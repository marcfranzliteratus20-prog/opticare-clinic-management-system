<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::findOrFail(session('user'));

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(session('user'));

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Only touch the password if they're actually trying to change it,
        // and only after verifying they know their current one.
        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
            }

            $user->password = $validated['new_password']; // model's 'hashed' cast hashes this automatically
        }

        $user->save();

        // Keep the session display name in sync since it's shown in the topbar/sidebar
        session(['user_name' => $user->name]);

        return back()->with('success', 'Your account has been updated.');
    }
}