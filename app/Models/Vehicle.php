<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    // app/Models/Vehicle.php
    protected $fillable = [
        'user_id',
        'owner_name',
        'type',
        'plate',
        'capacity',
        'license',
        'insurance',
        'is_instant',
        'status', // <- make sure this is here
        'latitude',
        'longitude' 
    ];
    
    

}
