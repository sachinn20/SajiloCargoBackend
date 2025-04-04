<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        return Vehicle::where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'plate' => 'required|string|max:255|unique:vehicles,plate',
            'license' => 'required|string|max:255',
            'insurance' => 'nullable|string|max:255',
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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vehicle->update($request->only(['type', 'capacity', 'plate', 'license', 'insurance']));

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
}
