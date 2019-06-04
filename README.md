# Fiken API PHP Client

Fiken.no is an online accounting system aimed at making accounting easy for small businesses.

# Installation

The package is not published on packagist.org yet, so for now you need to add the following to your `composer.json`:

```json
  "repositories": [
    {
      "url": "https://github.com/audunru/fiken-api-php-client.git",
      "type": "git"
    }
  ]
```

Afterwards, run this command:

```bash
$ composer update
```

# Usage

Test authentication:

```php
use audunru\FikenClient\FikenClient;

$client = new FikenClient();
$client->authenticate('username', 'password');

$client->user();
```

Get companies:

```php
use audunru\FikenClient\FikenClient;

$client = new FikenClient();
$client->authenticate('username', 'password');

$client->companies();
```

Get bank accounts, accounts, products and other resources that belong to a company.

In order to get these resources, you need to set

```php
use audunru\FikenClient\FikenClient;

$client = new FikenClient();
$client->authenticate('username', 'password');

$company = $client->company('123456789'); // 123456789 is the organization number

$company->bankAccounts();
$company->products();
$company->contacts();
$company->accounts(2019); // To get accounts, you need to set a year
```
