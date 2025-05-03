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

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        return $this->handleResponse(function () use ($request) {
            // Validate the request
            $request->validate([
                'email' => 'required|email',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->error('User not found.', 404);
            }

            // Update the user's password
            $user->password = Hash::make($request->password);
            $user->save();

            return [
                'message' => 'Password reset successfully.',
                'email' => $request->email,
            ];
        });
    }

    public function verifyToken(Request $request)
    {
        return $this->handleResponse(function () use ($request) {
            // Validate the input
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'token' => 'required|string|size:6',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation errors', 422, $validator->errors());
            }

            $email = $request->email;
            $token = $request->token;

            // Check if the token exists and is valid
            $resetRecord = DB::table('password_reset_tokens')
                ->where('email', $email)
                ->where('token', $token)
                ->where('created_at', '>=', now()->subMinutes(15)) // Token expires after 15 minutes
                ->first();

            if (!$resetRecord) {
                return $this->error('Invalid or expired token', 400);
            }


            return [
                'email' => $email,
                'message' => 'Token is valid',
            ];
        });
    }
}
