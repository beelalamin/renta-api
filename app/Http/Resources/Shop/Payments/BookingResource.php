<?php

namespace App\Http\Resources\Shop\Payments;

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
        // if ($request->routeIs('bookings.index')) {
        //     return [
        //         'id' => $this->id,
        //         'vehicle' => $this->vehicle->title,
        //         'status' => $this->status,
        //         'total_amount' => $this->total_amount,
        //     ];
        // } else {
        return [
            'thumbnail' => $this->vehicle->thumbnail->url,
            'vehicle' => $this->vehicle->title,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'type' => $this->type,
            'mileage' => $this->mileage,
            'infant_seat' => $this->infant_seat,
            'additional_driver' => $this->additional_driver,
            'pickup_at' => $this->pickup_at,
            'return_at' => $this->return_at,
            'transaction_id' => $this->payment->transaction_id,
            'created_at' => $this->created_at,
        ];
        // }
    }
}
