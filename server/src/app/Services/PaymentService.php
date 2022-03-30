<?php

namespace App\Services;

use App\Helpers\PriceUtils;
use App\Helpers\TimeUtils;
use App\Models\Bay;
use App\Models\Booking;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Carbon;

class PaymentService {
    public function pay($bay_id, $code){
        $bay = Bay::find($bay_id);
        $bay->available = true;
        $bay->save();
        
        $booking = Booking::where([
                                'code' => $code,
                                'paid' => false,
                            ])
                            ->first();
        $booking->paid = true;
        $booking->save();

        $transaction = Transaction::create([
            'booking_id' => $booking->id, 
            'duration' => TimeUtils::getHourDiffs(Carbon::create($booking->created_at), Carbon::now()),
            'amount' => PriceUtils::getPrice(
                TimeUtils::getHourDiffs(Carbon::create($booking->created_at), Carbon::now()),
            ), 
            'payment_method' => 'cash', 
        ]);

        return $transaction;
    }
}