<?php

namespace App\Http\Resources\V1\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'user_id' => $this->user_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'transactionId' => $this->transaction_id,
            'paidAt' => $this->created_at,
        ];
    }
}
