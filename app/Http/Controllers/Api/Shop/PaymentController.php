<?php

namespace App\Http\Controllers\api\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\Payments\StorePaymentRequest;
use App\Http\Resources\Shop\Payments\PaymentResource;
use App\Models\shop\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $payments = Payment::whereHas('customer', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();

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
                'success' => 'Transaction processed successfully!',
                'payment_id' => $payment->id,
            ], 201)
            : response()->json(['error' => 'Transaction Failed!'], 400);
    }

}
