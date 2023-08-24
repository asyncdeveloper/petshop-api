<?php

use Illuminate\Support\Facades\Route;
use Asyncdeveloper\CurrencyExchangeRate\Controllers\CurrencyExchangeController;

Route::get('/api/v1/currency-exchange', CurrencyExchangeController::class)->name('currency-exchange');
