<?php

use App\Models\serviceOrders;
use App\Http\Controllers\ServiceOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function () {
    return 'pong';
});

Route::prefix('service_orders')->group(function () {
    Route::get('/all', [ServiceOrderController::class, 'getAllServiceOrders']);
    Route::get('/{page?}/{vehiclePlate?}', [ServiceOrderController::class, 'getServiceOrders']);
});



