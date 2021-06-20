# Geo Target IP

[![License](https://poser.pugx.org/mawuekom/geo-target-ip/license)](https://packagist.org/packages/mawuekom/geo-target-ip)

A PHP package to geo targeting IP address.

This package uses [Geoplugin API](http://www.geoplugin.com/) to get IP informations.

## Installation

You can install the package via composer:

```bash
composer require mawuekom/geo-target-ip
```

## Usage

```php
use Mawuekom\GeoTargetIp\GeoTargetIp;

class Test
{
    use GeoTargetIp;

    public function ipDetails()
    {
        return $this ->locate('125.0.0.4');
    }
}
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

