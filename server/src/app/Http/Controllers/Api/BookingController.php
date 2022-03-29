<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function getByCode($code) {
        echo "booking code : $code";

        // TODO: 
        // fetch from booking service
        // calculate price based on hourly pricing model
        $booking = $this->bookingService->getActiveBooking($code);

        if ($code != 'BOOK1') {
            return response()->json([
                "message" => "Record not found."
            ], 404);
        }

        return response()->json($booking);
    }
}
