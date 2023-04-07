<?php

use App\Http\Controllers\PayPalController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/paypal', [PayPalController::class, 'createPayment'])->name('paypal.createPayment');
Route::get('/paypal/execute', [PayPalController::class, 'executePayment'])->name('paypal.executePayment');
Route::get('/paypal/cancel', [PayPalController::class, 'cancelPayment'])->name('paypal.cancelPayment');