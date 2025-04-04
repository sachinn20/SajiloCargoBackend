<?php

namespace Database\Seeders;
use App\Models\Vehicle;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestTripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
public function run(): void
{
    $vehicle = Vehicle::create([
        'user_id' => 1,
        'type' => 'Truck',
        'plate' => 'BA 2 KHA 5678',
        'capacity' => 10,
        'insurance' => 'Yes',
        'license' => 'Valid',
        'status' => 'available',
    ]);

    Trip::create([
        'user_id' => 1,
        'vehicle_id' => $vehicle->id, // ✅ reference actual ID
        'vehicle_name' => $vehicle->type,
        'vehicle_plate' => $vehicle->plate,
        'owner_name' => 'Group Owner',
        'from_location' => 'Kathmandu',
        'to_location' => 'Dang',
        'date' => '2025-04-03',
        'time' => '15:00',
        'shipment_type' => 'group',
        'available_capacity' => 10
    ]);
}
};
