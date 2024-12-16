<?php

use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/create-shipment', [ShipmentController::class, 'create_shipment'])->name('home');