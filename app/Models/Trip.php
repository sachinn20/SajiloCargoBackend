<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_LOADING = 'loading';
    const STATUS_EN_ROUTE = 'en_route';
    const STATUS_DELAYED = 'delayed';
    const STATUS_ARRIVED = 'arrived';
    const STATUS_UNLOADING = 'unloading';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_SCHEDULED,
            self::STATUS_LOADING,
            self::STATUS_EN_ROUTE,
            self::STATUS_DELAYED,
            self::STATUS_ARRIVED,
            self::STATUS_UNLOADING,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
    }

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
        'status',
    ];

    public function vehicle()
{
    return $this->belongsTo(Vehicle::class);
}



}
