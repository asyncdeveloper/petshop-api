<?php

namespace Asyncdeveloper\CurrencyExchangeRate\Exceptions;

use Illuminate\Validation\ValidationException;

class NotFound extends ValidationException
{
    public $status = 404;
}
