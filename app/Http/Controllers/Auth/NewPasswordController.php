<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    // Validate input manually
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation error.',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Find the user
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'message' => 'User not found.',
        ], 404);
    }

    // Update the password
    $user->password = Hash::make($request->password);
    $user->save();

    return response()->json([
        'message' => 'Password reset successfully.',
        'email' => $request->email,
    ]);
}

    public function verifyToken(Request $request)
{
    // Step 1: Validate the input
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'token' => 'required|string|size:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], 422);
    }

    $email = $request->email;
    $token = $request->token;

    // Step 2: Check if the token exists and is still valid
    $resetRecord = DB::table('password_reset_tokens')
        ->where('email', $email)
        ->where('token', $token)
        ->where('created_at', '>=', now()->subMinutes(15))
        ->first();

    if (!$resetRecord) {
        return response()->json([
            'message' => 'Invalid or expired token',
        ], 400);
    }

    // Step 3: Return success response
    return response()->json([
        'email' => $email,
        'message' => 'Token is valid',
    ], 200);
}
}
