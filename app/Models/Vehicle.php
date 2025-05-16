<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'owner_name',
        'type',
        'plate',
        'capacity',
        'license',
        'insurance',
        'is_instant',
        'status',
        'latitude',
        'longitude',
        'total_distance_travelled',
        'maintenance_threshold_km',
        'maintenance_status',
        'last_maintenance_at_distance',
    ];

    // ✅ Relationship: Vehicle belongs to a User
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
