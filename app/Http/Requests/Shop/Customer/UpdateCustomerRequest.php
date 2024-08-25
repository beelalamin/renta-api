<?php

namespace App\Http\Requests\Shop\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
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
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'street_address' => ['required', 'string'],
            'flight_number' => ['nullable', 'string'],
        ];
    }
}
