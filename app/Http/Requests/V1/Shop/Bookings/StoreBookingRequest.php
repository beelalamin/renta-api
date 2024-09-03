<?php

namespace App\Http\Requests\V1\Shop\Bookings;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{

    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'payment_id' => ['required', 'integer', 'exists:payments,id', 'unique:bookings,payment_id,'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'status' => ['required', 'string'],
            'type' => ['required', 'string', 'in:rental,subscription'],
            'protection' => ['required', 'string', 'in:standard,advance'],
            'mileage' => ['nullable', 'string'],
            'infant_seat' => ['nullable', 'string'],
            'additional_driver' => ['nullable', 'integer'],
            'pickup_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'return_at' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
