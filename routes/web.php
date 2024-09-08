<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealController;

Route::get('/', [DealController::class,'index'])->name('deals.index');
Route::get('/deals/create', [DealController::class,'create'])->name('deals.create');
Route::get('/deals/show/{deal}', [DealController::class,'show'])->name('deals.show');
Route::post('/deals/store', [DealController::class, 'store'])->name('deals.store');