# CurrencyExchangeRate

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Converts amount in EUR to a given currency.

## Installation

Via Composer

``` bash
$ composer require asyncdeveloper/currency-exchange-rate
```

## Usage

This package exposes an endpoint `(GET) /api/v1/currency-exchange` :

supported parameters:
-   `amount` - The amount to be converted
-   `currency` - The currency it is converting to

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email contact@asyncdeveloper.com instead of using the issue tracker.

## Credits

- [Oluwaseyi Adeogun][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/asyncdeveloper/currency-exchange-rate.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/asyncdeveloper/currency-exchange-rate.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/asyncdeveloper/currency-exchange-rate/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/asyncdeveloper/currency-exchange-rate
[link-downloads]: https://packagist.org/packages/asyncdeveloper/currency-exchange-rate
[link-travis]: https://travis-ci.org/asyncdeveloper/currency-exchange-rate
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/asyncdeveloper
[link-contributors]: ../../contributors
