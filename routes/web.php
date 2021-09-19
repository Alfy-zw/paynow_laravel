<?php

use App\Http\Controllers\ProcessPaymentController;
use Illuminate\Support\Facades\Route;
use Paynow\Payments\Paynow;
use Illuminate\Http\Request;
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
    return view('payment_form');
});




Route::get('/alfy/paynow/checkout',[ProcessPaymentController::class,'check_out'])->name('payment.process');
