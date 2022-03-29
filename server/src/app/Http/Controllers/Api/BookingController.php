<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function getByCode($code) 
    {
        $booking = $this->bookingService->getActiveBooking($code);

        if (!$booking) {
            return response()->json([
                "message" => "Record not found."
            ], 404);
        }

        return response()->json($booking);
    }

    public function create(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'bay_id' => 'bail|required|exists:App\Models\Bay,id',
            'renter' => 'bail|required|string|max:255',
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                "message" => "Bad request object."
            ], 400);
        }
 
        $validated = $validator->validated();

        try {
            $booking = $this->bookingService->createNewBooking((object) $validated);
        } catch (Throwable $e) {
            return response()->json([
                "message" => $e->getMessage() 
            ], 500);
        }

        return response()->json($booking);
    }
}
