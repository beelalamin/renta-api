<?php

namespace App\Http\Controllers\V1\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Shop\SubscriptionResource;
use App\Models\Shop\Booking;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $subscriptions = Booking::where('user_id', $userId)
            ->where('booking_type', 'subscription')
            ->get();

        if ($subscriptions && $subscriptions->isNotEmpty()) {
            return response()->json(SubscriptionResource::collection($subscriptions));
        }

        if ($subscriptions) {
            return response()->json(['error' => 'No subscription found!'], 404);
        }

        return response()->json(['error' => 'Failed to fetch data!'], 400);
    }


    public function show(string $id)
    {
        $userId = Auth::id();
        $booking = Booking::where('user_id', $userId)
            ->where('booking_type', 'subscription')
            ->with('payments')->firstOrFail($id);

        if (!$booking) {
            return response()->json(['error' => 'Failed to fetch data!'], 404);
        }

        return response()->json(new SubscriptionResource($booking));

    }

}
