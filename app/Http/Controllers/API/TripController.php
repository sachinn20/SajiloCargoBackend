<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Vehicle;
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
        ]);

        return response()->json(['message' => 'Trip created successfully', 'trip' => $trip]);
    }

    public function destroy(Request $request, $id)
    {
        $trip = Trip::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();
        $trip->delete();

        return response()->json(['message' => 'Trip deleted successfully']);
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



public function search(Request $request)
{
    $request->validate([
        'from_location' => 'required|string',
        'to_location' => 'required|string',
        'date' => 'required|date',
        'shipment_type' => 'required|in:individual,group',
    ]);

    \Log::info('Searching trips for:', $request->all());


    $trips = Trip::with('vehicle')
        ->whereRaw('LOWER(from_location) LIKE ?', ['%' . strtolower($request->from_location) . '%'])
        ->whereRaw('LOWER(to_location) LIKE ?', ['%' . strtolower($request->to_location) . '%'])
        ->whereDate('date', $request->date)
        ->where('shipment_type', $request->shipment_type)
        ->where('available_capacity' ,">=", $request->capacity)
        ->get();
    return response()->json($trips);
}

public function tripBookings(Request $request, $id)
{
    $trip = Trip::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();

    $bookings = Booking::with('user:id,name')
        ->where('trip_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'trip' => $trip,
        'bookings' => $bookings,
    ]);
}

public function updateStatus(Request $request)
{
    $validator = Validator::make($request->all(), [
        'trip_id' => 'required|exists:trips,id',
        'status' => 'required|string|in:pending,scheduled,loading,en_route,delayed,arrived,unloading,completed,cancelled',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $trip = Trip::where('id', $request->trip_id)
                ->where('user_id', $request->user()->id)
                ->first();

    if (!$trip) {
        return response()->json(['error' => 'Trip not found or unauthorized.'], 404);
    }

    $trip->status = $request->status;
    $trip->save();

    return response()->json([
        'message' => 'Trip status updated successfully.',
        'trip' => $trip
    ]);
}



}
