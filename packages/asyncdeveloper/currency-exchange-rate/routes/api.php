<?php

use Asyncdeveloper\CurrencyExchangeRate\Controllers\CurrencyExchangeController;
use Illuminate\Support\Facades\Route;

Route::get('/api/v1/currency-exchange', CurrencyExchangeController::class)->name('currency-exchange');
