### Requirements

1. PHP 7.0
2. Composer v1

### Installation

```
composer install
```

###Configuration

```
1. In app.php change token for [https://api.exchangeratesapi.io]((https://api.exchangeratesapi.io/latest)) API token
'exchangeRatesApi' =>
        [
            'token' => 'YOUR TOKEN',
        ],
        
        
2. In fee_operations.php you can change fee configurations(percent, limits)
```

### Run script

```
php script.php input.csv
```

### Run tests

```
composer run test
```