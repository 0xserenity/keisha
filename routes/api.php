<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PricingController;
use App\Http\Controllers\Api\StepnPricingController;
use App\Http\Controllers\Api\StepnLoginController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/pricing', PricingController::class);
Route::middleware('auth:sanctum')->get('/stepn/pricing', StepnPricingController::class);
Route::middleware('auth:sanctum')->post('/stepn/login', StepnLoginController::class);