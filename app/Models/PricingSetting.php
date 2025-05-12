<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingSetting extends Model
{
    use HasFactory;

    // This must match your actual table name
    protected $table = 'pricing_settings';

    protected $fillable = [
        'price_per_km',
        'price_per_kg',
    ];

    public $timestamps = false; // Set this only if your table doesn't have created_at/updated_at
}
