<?php

namespace App\Services;


class BookingService {
    public function getActiveBooking($code) {
        return [
            'id' => 1,
            'renter' => 'Renter Name',
            'code' => 'BOOK1',
            'paid' => false,
            'hours' => 2, 
            'price' => 20 
        ];
    }
}