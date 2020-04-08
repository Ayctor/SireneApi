# SireneAPI

It is a small php client library to use the [Sirene API](https://entreprise.data.gouv.fr/api_doc_sirene).

See [official documentation](https://entreprise.data.gouv.fr/api_doc_sirene) for availables methods.

## Installation

```
composer require ayctor/sireneapi
```

## Usage

```php
use SireneApi\SireneApi;

$api = new SireneApi;

// Get all companies
$companies = $api->companies()->all();
// Get company by SIREN number
$company = $api->companies()->getBySiren('552081317');
// Get companies by other fields
$companies = SirenApi::companies()->getBy('code_postal', 77100);
// Get companies by other fields
$companies = $api->companies()->getBy([
    'code_postal' => 77100,
]);

// Get all estabslishments
$establishments = $api->establishments()->all();
// Get establishments by SIREN number
$establishments = $api->establishments()->getBySiren('552081317');
// Get establishment by SIRET number
$establishment = $api->establishments()->getBySiret('55208131785027');
// Get establishments by other fields
$establishments = $api->establishments()->getBy('code_postal', 77100);
// Get establishments by other fields
$establishments = SirenApi::establishments()->getBy([
    'code_postal' => 77100,
]);
```

## Errors

### getBySiret()

It will throw an exception if you use this function to retrieve companies

### getBy()

It will throw an exception if you use this function with the first param as a string and no second param.

## License

[MIT](https://github.com/Ayctor/SireneApi/blob/master/LICENSE)
