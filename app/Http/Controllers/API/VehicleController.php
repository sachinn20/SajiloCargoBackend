<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index(Request $request)
{
    $vehicles = Vehicle::where('user_id', $request->user()->id)->get();

    $vehicles = $vehicles->map(function ($v) {
        $remaining = max(
            0,
            ($v->maintenance_threshold_km + $v->last_maintenance_at_distance) - $v->total_distance_travelled
        );

        $v->kms_remaining_to_maintenance = $remaining;
        $v->maintenance_due = $remaining < 100;

        return $v;
    });

    return response()->json($vehicles);
}


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'plate' => 'required|string|max:255|unique:vehicles,plate',
            'license' => 'required|string|max:255',
            'insurance' => 'nullable|string|max:255',
            'is_instant' => 'nullable|boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vehicle = Vehicle::create([
            'user_id' => $request->user()->id,
            'owner_name' => $request->user()->name,
            'type' => $request->type,
            'capacity' => $request->capacity,
            'plate' => $request->plate,
            'license' => $request->license,
            'insurance' => $request->insurance,
            'is_instant' => $request->input('is_instant', false),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);

        return response()->json(['message' => 'Vehicle added', 'vehicle' => $vehicle], 201);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'plate' => 'required|string|max:255|unique:vehicles,plate,' . $id,
            'license' => 'required|string|max:255',
            'insurance' => 'nullable|string|max:255',
            'is_instant' => 'nullable|boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vehicle->update([
            'type' => $request->type,
            'capacity' => $request->capacity,
            'plate' => $request->plate,
            'license' => $request->license,
            'insurance' => $request->insurance,
            'is_instant' => $request->input('is_instant', $vehicle->is_instant),
            'latitude' => $request->input('latitude', $vehicle->latitude),
            'longitude' => $request->input('longitude', $vehicle->longitude),
        ]);

        return response()->json(['message' => 'Vehicle updated', 'vehicle' => $vehicle]);
    }

    public function destroy(Request $request, $id)
    {
        $vehicle = Vehicle::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $vehicle->delete();

        return response()->json(['message' => 'Vehicle deleted']);
    }

    public function availableNearby(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'weight' => 'nullable|numeric',
        ]);

        $lat = $request->lat;
        $lng = $request->lng;
        $weight = $request->weight ?? 0;

        $vehicles = Vehicle::where('is_instant', true)
            ->where('status', 'available')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('capacity', '>=', $weight)
            ->select('*', DB::raw("
                (6371 * acos(cos(radians($lat)) * cos(radians(latitude)) *
                cos(radians(longitude) - radians($lng)) + sin(radians($lat)) *
                sin(radians(latitude)))) AS distance
            "))
            ->having('distance', '<=', 20)
            ->orderBy('distance')
            ->get();

        return response()->json($vehicles);
    }

    public function markAsMaintained(Request $request, $id)
{
    $vehicle = Vehicle::where('id', $id)
        ->where('user_id', $request->user()->id)
        ->firstOrFail();

    $vehicle->maintenance_status = 'maintained';
    $vehicle->last_maintenance_at_distance = $vehicle->total_distance_travelled;
    $vehicle->save();

    return response()->json(['message' => 'Vehicle marked as maintained.']);
}


}