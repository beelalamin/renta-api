<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Booking
{
    use HasFactory;

    protected $fillable = [
        'subscription_plan',
        'billing_cycle',
        'next_billing_date',
        'auto_renewal',
        'last_notified',
    ];

}
