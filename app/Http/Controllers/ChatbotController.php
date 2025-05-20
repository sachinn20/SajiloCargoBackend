<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatLog;
use App\Models\Booking;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $userId = auth()->id();
        $message = strtolower(trim($request->input('message')));
        $reply = '';
        $action = null;
        $suggestions = [];

        // Log user message
        ChatLog::create([
            'user_id' => $userId,
            'sender' => 'user',
            'message' => $message,
        ]);

        // GREETING HANDLER
        if (in_array($message, ['hi', 'hello', 'hey', 'good morning', 'good evening'])) {
            $reply = "👋 Hello! I'm Sajilo Support Bot.\n\nI can help you with:\n• 📦 Send a Package\n• 🚚 Track Delivery\n• ⚡ Instant Booking\n• 🧾 My Bookings";
            $suggestions = ['Send a package', 'Track package', 'Instant booking'];
        }

        // TRACKING CODE DETECTION
        elseif (preg_match('/\bSC-[A-Z0-9]{6,}\b/', strtoupper($message), $match)) {
            $trackingNo = $match[0];

            $booking = Booking::with('trip')
                ->where('user_id', $userId)
                ->where('tracking_no', $trackingNo)
                ->first();

            if ($booking) {
                $from = $booking->trip->from_location ?? 'Unknown';
                $to = $booking->trip->to_location ?? 'Unknown';

                $reply = "📦 Booking $trackingNo is currently {$booking->status}.\nFrom $from to $to.";
            } else {
                $reply = "❌ No booking found with tracking number *$trackingNo*.";
            }
        }


        // INTENT DETECTION
        else {
            $intent = null;

            if (Str::contains($message, ['send a package', 'schedule delivery'])) {
                $intent = 'schedule_booking';
            } elseif (Str::contains($message, ['instant booking', 'book now'])) {
                $intent = 'instant_booking';
            } elseif (Str::contains($message, ['track', 'where is my package'])) {
                $intent = 'ask_tracking';
            } elseif (Str::contains($message, ['cancel booking', 'cancel'])) {
                $intent = 'cancel_booking';
            } elseif (Str::contains($message, ['my bookings', 'booking history'])) {
                $intent = 'view_bookings';
            }

            switch ($intent) {
                case 'schedule_booking':
                    $reply = 'Great! Opening the schedule delivery screen for you.';
                    $action = 'go_to_schedule_booking';
                    $suggestions = ['Track package', 'Instant booking'];
                    break;

                case 'instant_booking':
                    $reply = 'Opening instant booking screen to find nearby vehicles.';
                    $action = 'go_to_instant_booking';
                    $suggestions = ['Track package', 'Send a package', 'My bookings'];
                    break;

                case 'ask_tracking':
                    $reply = 'Please provide your tracking number (e.g., SC-LWSTR4AJGY).';
                    $suggestions = ['SC-ABC123XYZ', 'My bookings'];
                    break;

                case 'cancel_booking':
                    $reply = 'To cancel a booking, please provide the tracking number (e.g., SC-XXXXXX).';
                    $suggestions = ['SC-ABC123XYZ', 'My bookings'];
                    break;

                case 'change_password':
                    $reply = 'Opening password change screen.';
                    $action = 'go_to_change_password';
                    $suggestions = ['My bookings', 'Track package'];
                    break;

                case 'view_bookings':
                    $reply = 'Here are your past bookings.';
                    $action = 'go_to_my_bookings';
                    $suggestions = ['Track package', 'Send a package'];
                    break;

                default:
                    $reply = "🤖 I'm not sure how to help with that. Here's what I can do:";
                    $suggestions = ['Send a package', 'Track package', 'Instant booking'];
                    break;
            }
        }

        // Log bot response
        ChatLog::create([
            'user_id' => $userId,
            'sender' => 'bot',
            'message' => $reply,
        ]);

        return response()->json([
            'reply' => $reply,
            'action' => $action,
            'suggestions' => $suggestions,
        ]);
    }

    public function history()
    {
        $userId = auth()->id();

        return ChatLog::where('user_id', $userId)
            ->orderBy('created_at')
            ->get(['sender', 'message', 'created_at']);
    }
}
