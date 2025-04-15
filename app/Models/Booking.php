<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'user_id',
        'status',
        'notes',
        'shipment_type',
        'weight',
        'dimension',
        'tracking_no',
        'amount',
        'no_of_packages',
        'receiver_name',
        'receiver_number'
    ];

    // Automatically generate tracking number on create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->tracking_no = 'SC-' . strtoupper(Str::random(10));
        });
    }

    // Booking.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function trip()
{
    return $this->belongsTo(Trip::class);
}



}
