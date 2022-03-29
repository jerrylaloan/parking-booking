<?php

use App\Http\Controllers\Api\BayController;
use App\Http\Controllers\Api\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// bays resource
Route::get('/bays', [BayController::class, 'get']);

// booking resource
Route::get('/booking/{code}', [BookingController::class, 'getByCode']);
Route::post('/booking', [BookingController::class, 'create']);

