<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;


class ResetPassword extends Controller
{
   
    public function sendPasswordResetToken(Request $request)
    {
         $request->validate(['email' => 'required|email|exists:users,email']);

         $status = Password::sendResetLink(
            $request->only('email')
        );

         return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent successfully.'], 200)
            : response()->json(['message' => 'Failed to send reset link. Please try again later.'], 500);
    }


    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'message' => 'Password reset successfully. You can now log in with your new password.',
            ], 200)
            : response()->json([
                'message' => 'Failed to reset password. Please check the token and try again.',
            ], 422);
    }

}
