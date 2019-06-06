# Fiken API PHP Client

Fiken.no is an online accounting system aimed at making accounting easy for small businesses.

The current goal of this package is to be able to create invoices and cash sales through the Fiken API.

You can use the Fiken API with demo accounts for free, otherwise there's a monthly fee per company.

[Fiken API official documentation](https://fiken.no/api/doc/)

I don't work for Fiken.

# Installation

The package is not published on packagist.org yet, so for now you need to add the following to your `composer.json` before you can install it:

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
$ composer require audunru/fiken-api-php-client
```

# Usage

## Test authentication

```php
use audunru\FikenClient\FikenClient;

$client = new FikenClient();
$client->authenticate('username', 'password'); // The Fiken API uses basic authentication

$client->user();
```

## Companies

```php
use audunru\FikenClient\FikenClient;

$client = new FikenClient();
$client->authenticate('username', 'password');

$client->companies();
```

## Bank accounts, products and other resources that belong to a company.

In order to get these resources, you need to get a company first.

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

Creating a customer:

```php
use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\FikenContact;

$client = new FikenClient();
$client->authenticate('username', 'password');

$company = $client->company('123456789'); // 123456789 is the organization number

$customer = new FikenContact(['name' => 'Firstname Lastname', 'customer' => true]);

$company->add($customer);
```
