<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Import Hash
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Return authenticated user
    public function user() {
        return response()->json([
            'message' => 'Logged user data',
            'user' => Auth::user(),
        ]);
    }

    // Profile view
    public function getProfile(Request $request) {
        $user = $request->user();
        $user->profile_photo_url = $user->profile_photo
            ? asset('storage/' . $user->profile_photo)
            : null;
    
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
    

    // Profile update
    public function updateProfile(Request $request) {
        $user = $request->user();
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',

        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
    
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::exists($user->profile_photo)) {
                Storage::delete($user->profile_photo);
            }
    
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }
    
        $user->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'data' => $user
        ]);
    }

    public function changePassword(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'confirmed', // Confirm the new password matches
                Password::min(8)
                    ->mixedCase()  // At least one uppercase letter
                    ->numbers()  // At least one number
                    ->symbols()  // At least one special character
            ],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect.'], 400);
        }

        // Check if the new password is the same as the old password
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json(['error' => 'You cannot use your old password as the new password.'], 422);
        }

        // Update the password
        $user->password = Hash::make($request->new_password); // Hash the new password
        $user->save(); // Save the updated password to the database

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ]);
    }
    
}
