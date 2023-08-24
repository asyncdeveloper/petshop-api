<?php

namespace Asyncdeveloper\CurrencyExchangeRate\Tests;

class CurrencyExchangeTest extends TestCase
{
    public function testThrowsErrorIfParametersAreMissing()
    {
        $response = $this->getJson(route('currency-exchange'));

        $response->assertJsonValidationErrorFor('currency');
    }
}
