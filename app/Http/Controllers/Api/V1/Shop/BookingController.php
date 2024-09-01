<?php

namespace App\Http\Controllers\Api\V1\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Shop\Bookings\StoreBookingRequest;
use App\Http\Resources\V1\Shop\BookingResource;
use App\Models\Shop\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $bookings = Booking::where('user_id', $userId)
            ->where('booking_type', 'rental')
            ->get();

        if ($bookings && $bookings->isNotEmpty()) {
            return response()->json(BookingResource::collection($bookings));
        }

        if ($bookings) {
            return response()->json(['error' => 'No bookings found!'], 404);
        }

        return response()->json(['error' => 'Failed to fetch data!']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();
        $booking = Booking::create($data);

        return $booking
            ? response()
                ->json([
                    'message' => 'Booking successfull!',
                    'booking' => $booking,
                ], 201)
            : response()
                ->json(['error' => 'Booking failed!'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::id();
        $booking = Booking::where('user_id', $userId)
            ->where('booking_type', 'rental')
            ->with('payments')->firstOrFail($id);

        if (!$booking) {
            return response()->json(['error' => 'Failed to fetch data! Booking not found for the given user.'], 404);
        }

        return response()->json(new BookingResource($booking));

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
