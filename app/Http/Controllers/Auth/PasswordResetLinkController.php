<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetTokenMail;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
 

public function store(Request $request): JsonResponse
{
    // Validate the email field
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    // Check if the user exists
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'message' => 'The provided email does not exist in our records.',
        ], 404);
    }

    // Generate a 6-digit token
    $token = random_int(100000, 999999);

    // Save or update the token in the password_reset_tokens table
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        [
            'token' => $token,
            'created_at' => now(),
        ]
    );

    Mail::to($request->email)->send(new PasswordResetTokenMail($request->email, $token));

    return response()->json([
        'message' => 'A password reset token has been generated.',
        'email' => $request->email,
        'token' => $token, // Optional to send to frontend (only for testing)
    ], 200);
}

}
