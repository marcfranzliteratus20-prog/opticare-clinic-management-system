<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show Account Settings / Profile page.
     */
    public function edit()
    {
        $userId = session('user');

        // If there is no logged-in user in the custom session,
        // send the user back to login instead of showing a 404.
        if (!$userId) {
            return redirect()
                ->route('login')
                ->with('error', 'Please log in first.');
        }

        $user = User::find($userId);

        // User no longer exists in the database.
        if (!$user) {
            session()->forget([
                'user',
                'user_name',
                'user_role',
            ]);

            return redirect()
                ->route('login')
                ->with('error', 'Your account could not be found. Please log in again.');
        }

        return view('profile.edit', compact('user'));
    }


    /**
     * Update Account Settings / Profile.
     */
    public function update(Request $request)
    {
        $userId = session('user');

        // Make sure a user is logged in.
        if (!$userId) {
            return redirect()
                ->route('login')
                ->with('error', 'Please log in first.');
        }

        $user = User::find($userId);

        // Make sure the account still exists.
        if (!$user) {
            session()->forget([
                'user',
                'user_name',
                'user_role',
            ]);

            return redirect()
                ->route('login')
                ->with('error', 'Your account could not be found. Please log in again.');
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'current_password' => [
                'nullable',
                'required_with:new_password',
                'string',
            ],

            'new_password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE BASIC INFORMATION
        |--------------------------------------------------------------------------
        */

        $user->name = $validated['name'];
        $user->email = $validated['email'];


        /*
        |--------------------------------------------------------------------------
        | CHANGE PASSWORD
        |--------------------------------------------------------------------------
        |
        | Only change the password if the user entered a new password.
        |
        */

        if (!empty($validated['new_password'])) {

            // Verify current password first.
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
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            | Your User model already has:
            |
            | 'password' => 'hashed'
            |
            | Therefore Laravel will automatically hash this password
            | when the model is saved.
            |--------------------------------------------------------------------------
            */

            $user->password = $validated['new_password'];
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE USER
        |--------------------------------------------------------------------------
        */

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | UPDATE CUSTOM SESSION
        |--------------------------------------------------------------------------
        |
        | Your application uses these session values in the layout:
        |
        | session('user')
        | session('user_name')
        | session('user_role')
        |
        */

        session([
            'user' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
        ]);

        session()->save();


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Your account has been updated successfully.');
    }
}