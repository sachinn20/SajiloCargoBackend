<?php

namespace App\Http\Controllers\API;
use App\Models\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function index(Request $request)
{
    return Notification::where('user_id', $request->user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
}
}
