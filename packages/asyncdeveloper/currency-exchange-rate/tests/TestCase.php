<?php

namespace Asyncdeveloper\CurrencyExchangeRate\Tests;

use Asyncdeveloper\CurrencyExchangeRate\CurrencyExchangeRateServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    protected function getPackageProviders($app): array
    {
        return [
            CurrencyExchangeRateServiceProvider::class,
        ];
    }
}
