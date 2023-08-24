<?php

namespace Asyncdeveloper\CurrencyExchangeRate\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Asyncdeveloper\CurrencyExchangeRate\Exceptions\NotFound;
use Asyncdeveloper\CurrencyExchangeRate\CurrencyExchangeRate;
use Asyncdeveloper\CurrencyExchangeRate\Exceptions\ExchangeRateUnavailable;

class CurrencyExchangeController extends Controller
{
    /**
     * @throws ExchangeRateUnavailable
     * @throws NotFound
     */
    public function __invoke(Request $request, CurrencyExchangeRate $converter): JsonResponse
    {
        $request->validate([
            'currency' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $amount = $request->query('amount');
        $currencyToExchange = $request->query('currency');

        $convertedAmount = $converter->convertCurrency($amount, $currencyToExchange);

        return response()->json([
            'success' => true,
            'data' => [
                'converted_amount' => $convertedAmount,
                'converted_currency' => $currencyToExchange,
            ],
        ]);
    }
}
