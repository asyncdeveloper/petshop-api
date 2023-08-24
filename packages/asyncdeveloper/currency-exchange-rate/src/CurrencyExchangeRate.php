<?php

namespace Asyncdeveloper\CurrencyExchangeRate;

use Asyncdeveloper\CurrencyExchangeRate\Exceptions\ExchangeRateUnavailable;
use Asyncdeveloper\CurrencyExchangeRate\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Http;

class CurrencyExchangeRate
{
    /**
     * @throws NotFoundException|ExchangeRateUnavailable
     */
    public function convertCurrency(float $amount, string $currencyToExchange): float
    {
        $response = $this->getDataFromApi();

        $rates = $response['Cube']['Cube']['Cube'];
        $rate = null;

        foreach ($rates as $currentRate) {
            if ($currentRate['@attributes']['currency'] === $currencyToExchange) {
                $rate = $currentRate['@attributes']['rate'];
                break;
            }
        }

        if (! $rate) {
            throw NotFoundException::withMessages(["Exchange rate not found for currency $currencyToExchange"]);
        }

        return round($amount * $rate, 3);
    }

    /**
     * @throws ExchangeRateUnavailable
     */
    private function getDataFromApi()
    {
        $response = Http::get(config('currency-exchange-rate.api_url'));

        if ($response->failed()) {
            throw ExchangeRateUnavailable::withMessages(["Exchange Rate API not available"]);
        }

        $xml = simplexml_load_string($response->body());
        return json_decode(json_encode($xml), TRUE);
    }
}
