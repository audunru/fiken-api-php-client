# Fiken API PHP Client

Fiken.no is an online accounting system aimed at making accounting easy for small businesses.

You can use this package to retrieve resources (companies, products, accounts, etc) from Fiken, or create new resources (eg. a customer or a product). You can also create invoices and cash sales.

You can use the Fiken API with demo accounts for free, otherwise there's a monthly fee per company.

[Fiken API official documentation](https://fiken.no/api/doc/)

I don't work for Fiken.

# A word of warning

Please create a demo account in Fiken (it's free) and use that when integrating this package in your project, before you use it with a real Fiken account. The package performs almost no checks before connecting to the Fiken API, so you can very easily make a mistake and create erroneous data in Fiken.

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
composer require audunru/fiken-api-php-client
```

# Usage

## Test authentication

```php
use audunru\FikenClient\FikenClient;

$client = new FikenClient();

// The Fiken API uses basic authentication
// According to their documentation, you should create a separate user for accessing the API
$client->authenticate('username', 'password');

// $user is a User object
$user = $client->user();

echo $user->name; // Art Vandelay
```

## Companies

```php
use audunru\FikenClient\FikenClient;

$client = new FikenClient();
$client->authenticate('username', 'password');

// $companies is a Collection, so you can use Laravel Collection methods to filter or get etc.
// See https://laravel.com/docs/5.8/collections
$companies = $client->companies();
$company = $companies->first();

echo $company->name; // Vandelay Industries
```

## Bank accounts, products and other resources that belong to a company.

In order to get these resources, you need to get a company first.

```php
use audunru\FikenClient\FikenClient;

$client = new FikenClient();
$client->authenticate('username', 'password');

// $company is a Company object
$company = $client->setCompany('123456789'); // 123456789 is the organization number

echo $company->name; // Vandelay Industries

// These are all collections, so the Laravel Collection methods can be used on them
$bankAccounts = $company->bankAccounts();
$products = $company->products();
$contacts = $company->contacts();
$accounts = $company->accounts(2019); // To get accounts, you need to set a year

// $product is a Product object
$product = $products->firstWhere('name', 'Latex');
```

Creating a customer:

```php
use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Contact;

$client = new FikenClient();
$client->authenticate('username', 'password');

$company = $client->setCompany('123456789');

$customer = new Contact(['name' => 'Kel Varnsen', 'customer' => true]);

// $saved is a new FikenCustomer object
$saved = $company->add($customer);
```

Creating an invoice:

```php
use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Invoice;
use audunru\FikenClient\Models\InvoiceLine;

$client = new FikenClient();
$client->authenticate('username', 'password');

$company = $client->setCompany('123456789');

// Create a new invoice object
$invoice = new Invoice(['issueDate' => '2019-01-01', 'dueDate' => '2019-01-15']);

// Find an existing customer of this company and set it on the invoice
$customer = $company->contacts()->firstWhere('name', 'Kel Varnsen');
$invoice->setCustomer($customer);

// Find a bank account and set it on the invoice
$bankAccount = $company->bankAccounts()->firstWhere('number', '12341234999');
$invoice->setBankAccount($bankAccount);

// Set invoice text
$invoice->invoiceText = 'Payment for import and export services';

// Find a product
$product = $company->products()->firstWhere('name', 'Chips');

// Create a new invoice line
$line = new InvoiceLine(['netAmount' => 8000, 'vatAmount' => 2000, 'grossAmount' => 10000]);
// Set product on the invoice line
$line->setProduct($product);

// Add the invoice line to the invoice
$invoice->add($line);

// Add the invoice to the company
$saved = $company->add($invoice);
// $saved is a new Invoice object
```

# Development

## Testing

Run tests:

```bash
composer test
```

The tests in the directory `tests\Feature` connect to the Fiken API. Before running these tests, you will have to set a username, password and organization number in the file `.env.testing`.

WARNING: Create a dummy account in Fiken and use that to run your tests, otherwise the tests will generate fake data in your Fiken account!

Tests that connect to the Fiken API have to be run with this command:

```
composer test -- --group dangerous
```
