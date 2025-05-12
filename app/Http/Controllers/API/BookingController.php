<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Notification;
use Illuminate\Support\Str;

class BookingController extends Controller
{
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
        'receiver_number' => 'required|string|size:10',
        'payment_mode' => 'required|in:cash,khalti', // ✅

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
            'payment_mode' => $validated['payment_mode'], // ✅
            'is_paid' => false,
            'khalti_transaction_id' => null,
     ]);


        if ($trip->user_id) {
            Notification::create([
                'user_id' => $trip->user_id,
                'actor_id' => $request->user()->id,
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

        public function instant(Request $request)
            {
            $request->validate([
                'pickup' => 'required|string',
                'dropoff' => 'required|string',
                'weight' => 'required|numeric',
                'receiver_name' => 'required|string',
                'receiver_number' => 'required|string|size:10',
                'notes' => 'nullable|string',
                'dimension' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'amount' => 'required|numeric', // ✅ Add this
                'payment_mode' => 'required|in:cash,khalti',
            ]);


            $vehicle = Vehicle::where('is_instant', true)
                ->where('status', 'available')
                ->where('capacity', '>=', $request->weight)
                ->first();

            if (!$vehicle) {
                return response()->json(['error' => 'No available instant vehicle found'], 404);
            }

            // Update vehicle's last known location
            if ($request->has(['latitude', 'longitude'])) {
                $vehicle->latitude = $request->latitude;
                $vehicle->longitude = $request->longitude;
            }

            $vehicle->save();

            $trip = Trip::create([
                'user_id' => $vehicle->user_id,
                'vehicle_id' => $vehicle->id,
                'vehicle_name' => $vehicle->type,
                'vehicle_plate' => $vehicle->plate,
                'owner_name' => $vehicle->owner_name,
                'from_location' => $request->pickup,
                'to_location' => $request->dropoff,
                'shipment_type' => 'individual',
                'available_capacity' => $vehicle->capacity - $request->weight,
                'status' => 'assigned',
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i'),
            ]);

            $booking = Booking::create([
                'user_id' => $request->user()->id,
                'trip_id' => $trip->id,
                'tracking_no' => 'SC-' . strtoupper(Str::random(10)),
                'status' => 'pending',
                'shipment_type' => 'individual',
                'weight' => $request->weight,
                'dimension' => $request->dimension ?? '',
                'notes' => $request->notes ?? 'Instant booking',
                'receiver_name' => $request->receiver_name,
                'receiver_number' => $request->receiver_number,
                'amount' => $request->amount, // ✅ Fixed: now dynamic
                'no_of_packages' => 1,
                'payment_mode' => $request->payment_mode,
                'is_paid' => false,
                'khalti_transaction_id' => null,
            ]);


            Notification::create([
                'user_id' => $trip->user_id,
                'actor_id' => $request->user()->id,
                'title' => 'Instant Booking Received',
                'message' => $request->user()->name . ' booked an instant trip from ' . $trip->from_location . ' to ' . $trip->to_location,
            ]);

            return response()->json([
                'message' => 'Instant booking successful',
                'tracking_no' => $booking->tracking_no,
                'booking' => $booking,
                'trip' => $trip,
            ]);
    }


    public function received(Request $request)
    {
        try {
            $bookings = Booking::with([
                'user:id,name,phone_number',
                'trip:id,user_id,from_location,to_location,date,time,vehicle_name,vehicle_plate'
            ])
            ->whereHas('trip', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->latest()
            ->get();

            return response()->json($bookings);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function myBookings(Request $request)
    {
        try {
            $userId = $request->user()->id;

            $bookings = Booking::with([
                'trip:id,from_location,to_location,date,time,vehicle_name,vehicle_plate'
            ])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

            return response()->json(['data' => $bookings]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function destroy($id, Request $request)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($booking->status !== 'pending') {
            return response()->json(['error' => 'Only pending bookings can be deleted'], 403);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($booking->status !== 'pending') {
            return response()->json(['error' => 'Only pending bookings can be updated'], 403);
        }

        $validated = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_number' => 'required|string|size:10',
            'weight' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
            'dimension' => 'nullable|string',
            'no_of_packages' => 'required|integer|min:1'
        ]);

        $booking->update($validated);

        return response()->json(['message' => 'Booking updated successfully', 'booking' => $booking]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:accepted,rejected']);

        $booking = Booking::with('trip.vehicle', 'user')->findOrFail($id);

        if ($booking->trip->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $booking->status = $request->status;
        $booking->save();

        if ($booking->status === 'accepted') {
            $trip = $booking->trip;
            $vehicle = $trip->vehicle;
            if ($vehicle) {
                $vehicle->status = 'assigned';
                $vehicle->save();
            }
            $trip->available_capacity = max(0, $trip->available_capacity - $booking->weight);
            $trip->save();
        }

        Notification::create([
            'user_id' => $booking->user_id,
            'actor_id' => $request->user()->id,
            'title' => 'Booking ' . ucfirst($booking->status),
            'message' => 'Your booking from ' . $booking->trip->from_location . ' to ' . $booking->trip->to_location . ' has been ' . $booking->status,
        ]);

        return response()->json(['message' => 'Booking status updated', 'booking' => $booking]);
    }

    public function track($trackingNo)
    {
        $booking = Booking::with(['user', 'trip.vehicle'])
            ->where('tracking_no', $trackingNo)
            ->first();

        if (!$booking) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($booking);
    }

    public function earnings(Request $request)
{
    $user = $request->user();

    $bookings = Booking::with('user')
        ->whereHas('trip', function ($q) use ($user) {
            $q->where('user_id', $user->id); // trip made by vehicle owner
        })
        ->latest()
        ->get();

    $total = $bookings->sum('amount');
    $paid = $bookings->where('is_paid', true);
    $unpaid = $bookings->where('is_paid', false);

    return response()->json([
        'total' => $total,
        'bookings' => $bookings->map(function ($b) {
            return [
                'id' => $b->id,
                'tracking_no' => $b->tracking_no,
                'customer_name' => $b->user->name ?? 'N/A',
                'amount' => $b->amount,
                'is_paid' => $b->is_paid,
                'payment_mode' => $b->payment_mode,
            ];
        }),
    ]);
}


}
