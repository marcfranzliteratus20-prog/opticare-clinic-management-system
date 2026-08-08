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

        /*
        |--------------------------------------------------------------------------
        | Update name and email
        |--------------------------------------------------------------------------
        */

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        /*
        |--------------------------------------------------------------------------
        | Change password only when requested
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['new_password'])) {

            if (
                empty($validated['current_password']) ||
                !Hash::check(
                    $validated['current_password'],
                    $user->password
                )
            ) {
                return back()
                    ->withInput($request->except([
                        'current_password',
                        'new_password',
                        'new_password_confirmation',
                    ]))
                    ->withErrors([
                        'current_password' =>
                            'Your current password is incorrect.'
                    ]);
            }

            /*
            | Hash the new password manually.
            */

            $user->password = Hash::make(
                $validated['new_password']
            );
        }

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | Keep session information updated
        |--------------------------------------------------------------------------
        */

        session([
            'user_name' => $user->name,
            'user_role' => $user->role,
        ]);

        return back()->with(
            'success',
            'Your account has been updated successfully.'
        );
    }
}