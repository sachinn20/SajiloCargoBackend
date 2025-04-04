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
        'capacity',
        'plate',
        'license',
        'insurance',
    ];

}
