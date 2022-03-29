<?php

namespace App\Services;

use App\Helpers\PriceUtils;
use App\Helpers\TimeUtils;
use App\Models\Booking;

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
            'hours' => TimeUtils::getHourDiffs('date1', 'date2'), 
            'price' => PriceUtils::getPrice(TimeUtils::getHourDiffs('date1', 'date2'))
        ];
    }
}