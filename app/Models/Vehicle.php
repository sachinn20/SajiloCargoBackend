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
    ];

    // ✅ Relationship: Vehicle belongs to a User
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
