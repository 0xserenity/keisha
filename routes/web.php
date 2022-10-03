<?php

use App\Http\Controllers\GetNewDealsController;
use App\Http\Controllers\Pages\DealsController;
use App\Http\Controllers\Pages\FindGoodDealsController;
use App\Http\Controllers\Pages\HealthPointRestoreCostCalculatorController;
use App\Http\Controllers\HealthPointRestoreCostCalculateController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/deals/find', FindGoodDealsController::class)
        ->name('deals.find');
    Route::post('/deals/get', GetNewDealsController::class)
        ->name('deals.get');
});

Route::get('/hp', HealthPointRestoreCostCalculatorController::class)
    ->name('hp');
Route::post('/hp/calculate', HealthPointRestoreCostCalculateController::class)
    ->name('hp.calculate');
Route::get('/deals', DealsController::class)
    ->name('deals');