<?php

namespace App\Services;

use App\Helpers\PriceUtils;
use App\Helpers\TimeUtils;
use App\Models\Bay;
use App\Models\Booking;
use Carbon\Carbon;

class BookingService {
    /**
     * Get active booking record by code
     * 
     * @param  string $code - unique booking code 
     * @return object [
     *     'id' => (integer)
     *     'renter' => (string) 
     *     'code' => (string)
     *     'paid' => (boolean) 
     *     'hours' => (float)
     *     'price' => (integer)
     * ]
     */
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
            ), 
            'bay_id' => $booking->bay_id
        ];
    }

    /**
     * Create new booking record
     * 
     * @param object $payload - [
     *     'bay_id' => (integer)
     *     'renter' => (string) 
     * ]
     * 
     * @return Booking
     */
    public function createNewBooking($payload){
        $newBooking = Booking::create([
	   		'bay_id' => $payload->bay_id, 
            'renter' => $payload->renter, 
            'code' => strtoupper($this->generateRandomString(5)),
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

    /**
     * Generate random string for booking code
     * 
     * @param  integer $length - expected length of the code
     * @return string - random generated string for booking code. ex: ABC12
     */
    private function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}