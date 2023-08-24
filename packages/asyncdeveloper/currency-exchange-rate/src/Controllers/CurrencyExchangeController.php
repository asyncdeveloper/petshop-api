<?php

namespace Asyncdeveloper\CurrencyExchangeRate\Controllers;

use Asyncdeveloper\CurrencyExchangeRate\CurrencyExchangeRate;
use Asyncdeveloper\CurrencyExchangeRate\Exceptions\ExchangeRateUnavailable;
use Asyncdeveloper\CurrencyExchangeRate\Exceptions\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CurrencyExchangeController extends Controller
{

    /**
     * @throws ExchangeRateUnavailable
     * @throws NotFoundException
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
            'data' =>  [
                'converted_amount' => $convertedAmount,
                'converted_currency' => $currencyToExchange,
            ],
        ]);
    }

}
