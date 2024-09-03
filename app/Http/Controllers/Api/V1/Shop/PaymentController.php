<?php

namespace App\Http\Controllers\Api\V1\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Shop\Payments\StorePaymentRequest;
use App\Http\Resources\V1\Shop\Payments\PaymentResource;
use App\Models\Shop\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $payments = Payment::where('user_id', $id)->get();

        return $payments ? response()->json([
            'payments' => PaymentResource::collection($payments),
        ], 200) : response()->json(['error' => 'Failed to fetch data'], 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $data = $request->validated();
        $payment = Payment::create($data);

        return $payment
            ? response()->json([
                'success' => 'Payment success!',
                'payment_id' => $payment->id,
            ], 201)
            : response()->json(['error' => 'Payment failed!'], 400);
    }

}
