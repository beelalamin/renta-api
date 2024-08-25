<?php

namespace App\Http\Requests\Shop\Payments;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'amount' => ['required', 'integer'],
            'status' => ['required', 'string', 'in:success,failed'],
            'method' => ['required', 'string', 'in:credit_card,cash_on_delivery'],
            'transaction_id' => ['required', 'string', 'unique:payments,transaction_id'],
        ];
    }
}
