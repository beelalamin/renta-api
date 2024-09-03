<?php

namespace App\Models\Shop;

use App\Models\shop\Payment;
use App\Models\products\Vehicle;
use App\Models\system\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'protection',
        'status',
        'booking_type',
        'booking_number',
        'mileage',
        'infant_seat',
        'driver',
        'is_active',
        'note',
        'pickup_location_id',
        'return_location_id',
        'pickup_date',
        'return_date',
        'subscription_plan',
        'billing_cycle',
        'next_billing_date',
        'auto_renewal',
        'last_notified',
    ];


    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pickupLocation()
    {
        return $this->belongsTo(Location::class, 'pickup_location_id');
    }

    public function returnLocation()
    {
        return $this->belongsTo(Location::class, 'return_location_id');
    }
}
