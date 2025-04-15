<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    public function index(Request $request)
    {
        return Trip::where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id',
            'from_location' => 'required|string',
            'to_location' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'shipment_type' => 'required|in:individual,group',
            'available_capacity' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vehicle = Vehicle::find($request->vehicle_id);

        $trip = Trip::create([
            'user_id' => $request->user()->id,
            'vehicle_id' => $vehicle->id,
            'vehicle_name' => $vehicle->type,
            'vehicle_plate' => $vehicle->plate,
            'owner_name' => $request->user()->name,
            'from_location' => $request->from_location,
            'to_location' => $request->to_location,
            'date' => $request->date,
            'time' => $request->time,
            'shipment_type' => $request->shipment_type,
            'available_capacity' => $request->shipment_type === 'group' ? $request->available_capacity : null,
            'status' => Trip::STATUS_PENDING,
        ]);

        return response()->json(['message' => 'Trip created successfully', 'trip' => $trip]);
    }

    public function update(Request $request, $id)
    {
        $trip = Trip::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();

        $validated = $request->validate([
            'from_location' => 'required|string',
            'to_location' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'shipment_type' => 'required|in:individual,group',
            'available_capacity' => 'nullable|numeric',
        ]);

        $trip->update($validated);

        return response()->json(['message' => 'Trip updated successfully']);
    }

    public function destroy(Request $request, $id)
    {
        $trip = Trip::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();
        $trip->delete();

        return response()->json(['message' => 'Trip deleted successfully']);
    }

    public function search(Request $request)
    {
        $request->validate([
            'from_location' => 'required|string',
            'to_location' => 'required|string',
            'date' => 'required|date',
            'shipment_type' => 'required|in:individual,group',
            'capacity' => 'nullable|numeric'
        ]);

        $from = trim(strtolower($request->from_location));
        $to = trim(strtolower($request->to_location));
        $date = $request->date;
        $shipmentType = $request->shipment_type;
        $capacity = $request->capacity;

        \Log::info('Trip Search Inputs', compact('from', 'to', 'date', 'shipmentType', 'capacity'));

        $query = Trip::query();
        $query->whereRaw('LOWER(from_location) LIKE ?', ["%$from%"])
              ->whereRaw('LOWER(to_location) LIKE ?', ["%$to%"])
              ->whereDate('date', '>=', $date)
              ->where('shipment_type', $shipmentType)
              ->where('status', Trip::STATUS_PENDING);

        if ($shipmentType === 'group' && $request->filled('capacity')) {
            $query->where('available_capacity', '>=', (float) $capacity);
        }

        $trips = $query->get();
        \Log::info('Matching trips count:', ['count' => $trips->count()]);

        if ($trips->isEmpty()) {
            \Log::warning('No trips matched. Returning fallback.');
            $trips = Trip::whereDate('date', '>=', now())->get();
        }

        return response()->json($trips);
    }

    public function tripBookings(Request $request, $id)
    {
        $trip = Trip::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();

        $bookings = Booking::with('user:id,name')
            ->where('trip_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['trip' => $trip, 'bookings' => $bookings]);
    }



    public function updateStatus(Request $request)
{
    \Log::info('Trip Status Update Request', [
        'trip_id' => $request->trip_id,
        'status' => $request->status,
        'user_id' => optional($request->user())->id,
    ]);

    $validator = Validator::make($request->all(), [
        'trip_id' => 'required|integer|exists:trips,id',
        'status' => 'required|string|in:' . implode(',', Trip::getStatuses()),
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = $request->user();
    $trip = Trip::findOrFail($request->trip_id);

    if ($trip->user_id !== $user->id) {
        return response()->json(['error' => 'Unauthorized: You cannot update this trip.'], 403);
    }

    if ($trip->status === 'completed') {
        return response()->json(['error' => 'Trip already completed. Status cannot be changed.'], 403);
    }

    $trip->status = $request->status;
    $trip->save();

    // 🟢 Reset vehicle status if trip is completed & vehicle is instant
    if ($request->status === 'completed') {
        $vehicle = Vehicle::find($trip->vehicle_id);
        if ($vehicle && $vehicle->is_instant) {
            $vehicle->status = 'available';
            $vehicle->save();
        }
    }

    // 🟡 Sync booking statuses
    Booking::where('trip_id', $trip->id)
        ->whereNotIn('status', ['rejected'])
        ->update(['status' => $trip->status]);

    return response()->json([
        'message' => 'Trip and bookings updated successfully.',
        'trip' => $trip
    ]);
}

}