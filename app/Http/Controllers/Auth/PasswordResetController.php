<?php

// app/Http/Controllers/Auth/PasswordResetController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class PasswordResetController extends Controller
{
    // Show the password reset request form
    public function showResetRequestForm()
    {
        return view('auth.password_reset');
    }

    // Handle sending the password reset link
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generate the reset token
        $token = Str::random(60);

        // Store the token in the password_resets table
        DB::table('password_reset')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Send the custom password reset email
        Mail::to($request->email)->send(new PasswordResetMail($token));

        return back()->with('status', 'We have emailed your password reset link!');
    }

    // Show the form for resetting the password
    public function showResetForm($token)
    {
        return view('auth.password_reset_form', ['token' => $token]);
    }

    // Handle password reset
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Find the reset token in the database
        $reset = DB::table('password_reset')->where('token', $request->token)->first();

        if (!$reset) {
            return back()->withErrors(['token' => 'This password reset token is invalid.']);
        }

        // Update the user's password
        $user = User::where('email', $reset->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with that email address.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Delete the reset token
        DB::table('password_reset')->where('email', $reset->email)->delete();
        Alert::toast('Your password has been reset!','success');
        return redirect()->route('login')->with('status', 'Your password has been reset!');
    }
}

