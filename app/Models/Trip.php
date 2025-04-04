<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'vehicle_name',
        'vehicle_plate',
        'owner_name',
        'from_location',
        'to_location',
        'date',
        'time',
        'shipment_type',
        'available_capacity',
        'status', // Add this
    ];
    
    
    public function vehicle(){
return $this->belongsTo(vehicle::class);
    }
}
