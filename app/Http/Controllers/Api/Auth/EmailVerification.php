<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerification extends Controller
{
    // Email Verification Notice Response
    public function VerificationNotice()
    {
        return response()->json([
            'message' => 'Verification email sent successfully'
        ], 200);
    }

    // Email Verification Handler
    public function EmailVerificationHandler(EmailVerificationRequest $request)
    {
        return $request->fulfill();
    }

    // Resend Verification Email
    public function resendEmailVerification(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified.'
            ], 200);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification email sent successfully.'
        ], 200);
    }
}
