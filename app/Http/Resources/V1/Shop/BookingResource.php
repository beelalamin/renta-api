<?php

namespace App\Http\Resources\V1\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lastPayment = $this->payments->where('booking_id', $this->id)->sortByDesc('created_at')->take(1)->mapInto(PaymentResource::class);

        return [
            'thumbnail' => $this->vehicle->thumbnail->url,
            'bookingNumber' => $this->booking_number,
            'vehicle' => $this->vehicle->title,
            'status' => $this->status,
            'bookingType' => $this->booking_type,
            'pickupDate' => $this->pickup_date,
            'pickupLocation' => $this->pickupLocation->name,
            'createdAt' => $this->created_at,
            'payment' => $lastPayment,
        ];
    }
}
