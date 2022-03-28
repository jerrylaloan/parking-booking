<?php

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

Route::get('/bays', function () {
    return response()->json([
      [
        'id' => 1,
        'location' => 'location 1',
        'available' => true,
      ], 
      [
        'id' => 2,
        'location' => 'location 2',
        'available' => true,
      ], 
      [
        'id' => 3,
        'location' => 'location 3',
        'available' => true,
      ], 
    ]);
});
