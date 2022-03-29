<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getByCode($code) {
        echo "booking code : $code";

        return response()->json([
            "message" => "Record not found."
        ], 404);
        // fetch from booking service
        // calculate price based on hourly pricing model

        // return response()->json([
        //     'code' => $code
        // ]);
    }
}
