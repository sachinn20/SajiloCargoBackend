<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
{
    $user = $request->user();
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // ✅ Updated query to include actor data
    $notifications = Notification::with('actor:id,name,profile_photo')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $unreadCount = $notifications->whereNull('read_at')->count();

    return response()->json([
        'notifications' => $notifications,
        'unread_count' => $unreadCount,
    ]);
}

    


    public function markAllAsRead(Request $request)
    {
        Notification::where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'All notifications marked as read.']);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $notification->update(['read_at' => now()]);

        return response()->json(['message' => 'Notification marked as read.']);
    }
}
