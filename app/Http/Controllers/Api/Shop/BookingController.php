<?php

namespace App\Http\Controllers\api\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\Bookings\StoreBookingRequest;
use App\Http\Resources\Shop\Payments\BookingResource;
use App\Models\shop\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $bookings = BookingResource::collection(Booking::where('customer_id', $id)->get());
        return response()->json($bookings);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();
        $booking = Booking::create($data);

        return $booking
            ? response()->json([
                'message' => 'Booking successfully!',
                'booking' => $booking,
            ], 201)
            : response()->json(['error' => 'Failed to create booking!'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bookings = new BookingResource(Booking::findOrFail($id));
        return response()->json($bookings);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
