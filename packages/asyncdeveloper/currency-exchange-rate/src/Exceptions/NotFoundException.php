<?php

namespace Asyncdeveloper\CurrencyExchangeRate\Exceptions;

use Illuminate\Validation\ValidationException;

class NotFoundException extends ValidationException
{
    public $status = 404;
}
