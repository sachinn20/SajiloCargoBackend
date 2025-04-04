<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\Notification;

class BookingController extends Controller
{
    // 📌 Customer books a trip
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'shipment_type' => 'required|in:individual,group',
            'weight' => 'required|numeric',
            'dimension' => 'nullable|string',
            'notes' => 'nullable|string',
            'amount' => 'required|numeric',
            'no_of_packages' => 'required|integer|min:1',
            'receiver_name' => 'required|string|max:255',
            'receiver_number' => 'required|string|max:10|min:10',
        ]);

        $trip = Trip::findOrFail($validated['trip_id']);

        $booking = Booking::create([
            'trip_id' => $trip->id,
            'user_id' => $request->user()->id,
            'shipment_type' => $validated['shipment_type'],
            'weight' => $validated['weight'],
            'dimension' => $validated['dimension'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'amount' => $validated['amount'],
            'no_of_packages' => $validated['no_of_packages'],
            'receiver_name' => $validated['receiver_name'],
            'receiver_number' => $validated['receiver_number'],
            'status' => 'pending',
        ]);

        // 🔔 Notify the trip owner
        if ($trip->user_id) {
            Notification::create([
                'user_id' => $trip->user_id,
                'title' => 'New Booking Request',
                'message' => $request->user()->name . ' requested your trip from ' . $trip->from_location . ' to ' . $trip->to_location,
            ]);
        }

        return response()->json([
            'message' => 'Booking placed successfully',
            'tracking_no' => $booking->tracking_no,
            'booking' => $booking
        ]);
    }

    // 📌 Vehicle owner sees all bookings for their trips
    public function received(Request $request)
    {
        $ownerId = $request->user()->id;

        $bookings = Booking::with(['user:id,name', 'trip:id,from_location,to_location,date,time,vehicle_name,vehicle_plate'])
            ->whereHas('trip', function ($query) use ($ownerId) {
                $query->where('user_id', $ownerId);
            })
            ->latest()
            ->get();

        return response()->json($bookings);
    }

    // 📌 Owner accepts/rejects a booking
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:accepted,rejected']);
    
        $booking = Booking::with('trip', 'user')->findOrFail($id);
    
        if ($booking->trip->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $booking->status = $request->status;
        $booking->save();
    
        // ✅ If accepted, subtract weight from trip capacity
        if ($booking->status === 'accepted') {
            $trip = $booking->trip;
            $trip->available_capacity = max(0, $trip->available_capacity - $booking->weight);
            $trip->save();
        }
    
        // 🔔 Notify the customer
        Notification::create([
            'user_id' => $booking->user_id,
            'title' => 'Booking ' . ucfirst($booking->status),
            'message' => 'Your booking from ' . $booking->trip->from_location . ' to ' . $booking->trip->to_location . ' has been ' . $booking->status,
        ]);
    
        return response()->json([
            'message' => 'Booking status updated',
            'booking' => $booking
        ]);
    }
    
}
