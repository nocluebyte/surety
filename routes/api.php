<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceApiController;

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

Route::namespace('Api')->group(function () {
    Route::post('sayhello', [AttendanceApiController::class, 'sayHello']);
    Route::post('transaction', [AttendanceApiController::class, 'transaction']);
    Route::get('transaction', function() {
        return [
            'status' => false,
            'message' => 'The GET method is not supported for this route. Supported methods: POST.'
        ];
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
