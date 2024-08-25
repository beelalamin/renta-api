<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'payment_id' => ['required', 'integer', 'exists:payments,id'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'type' => ['required', 'string', 'in:standard,advance'],
            'mileage' => ['nullable', 'string'],
            'infant_seat' => ['nullable', 'string'],
            'additional_driver' => ['nullable', 'string'],
            'pickup_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'return_at' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
