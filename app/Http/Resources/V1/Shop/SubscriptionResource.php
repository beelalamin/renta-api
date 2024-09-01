<?php

namespace App\Http\Resources\V1\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'thumbnail' => $this->vehicle->thumbnail->url,
            'bookingNumber' => $this->booking_number,
            'vehicle' => $this->vehicle->title,
            'status' => $this->status,
            'bookingType' => $this->booking_type,
            'pickupDate' => $this->pickup_date,
            'pickupLocation' => $this->pickupLocation->name,
            'subscriptionPlan' => $this->subscription_plan,
            'billingCycle' => $this->billing_cycle,
            'renewalDate' => $this->renewal_date,
            'autoRenewal' => $this->auto_renewal,
            'createdAt' => $this->created_at,
            'payments' => $this->payments,
        ];
    }
}
