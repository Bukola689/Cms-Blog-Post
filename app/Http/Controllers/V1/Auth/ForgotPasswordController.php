<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordReset;
use App\Rules\Email;
use App\Mail\Auth\PasswordResetMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|string'
        ]);
        
        if (! $user = User::firstWhere(['email' => $request->email])) {
            return "Email does not exist.";
        }

        $reset = PasswordReset::createToken($request->email);

        Mail::to($request->email)->send((new PasswordResetMail($user, $reset)));

        return "Reset password link has been sent to your email.";

    }
}
