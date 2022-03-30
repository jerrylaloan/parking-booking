<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }


    public function pay(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'bay_id' => 'bail|required|exists:App\Models\Bay,id',
            'code' => 'bail|required|string|max:5',
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                "message" => "Bad request object."
            ], 400);
        }
 
        $validated = $validator->validated();

        try {
            $payment = $this->paymentService->pay($validated['bay_id'], $validated['code']);
        } catch (Throwable $e) {
            dd($e->getMessage());
            return response()->json([
                "message" => "Internal server error." 
            ], 500);
        }

        return response()->json([
            'id' => $payment->id, 
            'booking_id' => $payment->booking_id, 
            'duration' => $payment->duration, 
            'amount' => $payment->amount, 
        ]);
    }
}
