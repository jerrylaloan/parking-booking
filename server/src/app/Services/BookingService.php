<?php

namespace App\Services;

use App\Helpers\PriceUtils;
use App\Helpers\TimeUtils;
use App\Models\Bay;
use App\Models\Booking;
use Carbon\Carbon;

class BookingService {
    public function getActiveBooking($code) {
        $booking = Booking::where([
                                'code' => $code,
                                'paid' => false,
                            ])
                            ->first();

        if (!$booking) return null;

        return [
            'id' => $booking->id,
            'renter' => $booking->renter,
            'code' => $booking->code,
            'paid' => $booking->paid,
            'hours' => TimeUtils::getHourDiffs(Carbon::create($booking->created_at), Carbon::now()),
            'price' => PriceUtils::getPrice(
                TimeUtils::getHourDiffs(Carbon::create($booking->created_at), Carbon::now()),
            )
        ];
    }

    public function createNewBooking($payload){
        $newBooking = Booking::create([
	   		'bay_id' => $payload->bay_id, 
            'renter' => $payload->renter, 
            'code' => 'BOOK3',
        ]);

        $booking = Booking::find($newBooking->id, [
                                    'id', 
                                    'bay_id', 
                                    'renter', 
                                    'code'
                                ]);

        Bay::where('id', $payload->bay_id)
            ->update(['available' => false]);

        return $booking;
    }
}