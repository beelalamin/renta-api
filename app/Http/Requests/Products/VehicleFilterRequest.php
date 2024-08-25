<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class VehicleFilterRequest extends FormRequest
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
            'filter.brand' => 'sometimes|string',
            'filter.categories' => 'sometimes|string',
            'filter.transmission' => 'sometimes|string|in:manual,automatic',
            'filter.price_range' => 'sometimes|array|regex:/^\d+,\d+$/',
            'filter.price_range.*' => 'numeric',
        ];

        // Laravel Query Builder
        // return [
        //     'brand' => 'sometimes|array',
        //     'brand.*' => 'integer|exists:brands,id',
        //     'categories' => 'sometimes|array',
        //     'categories.*' => 'integer|exists:categories,id',
        //     'transmission' => 'sometimes|string|in:manual,automatic',
        //     'price_range' => 'sometimes|string|regex:/^\d+,\d+$/',
        // ];

    }
}
