<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
    
}
