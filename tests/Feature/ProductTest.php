<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\FikenClient;
use audunru\FikenClient\Models\Product;
use audunru\FikenClient\Tests\TestCase;
use Illuminate\Support\Collection;

class ProductTest extends TestCase
{
    /**
     * @group dangerous
     */
    public function test_it_can_retrieve_products()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $products = $company->products();
        $product = $products->first();

        $this->assertInstanceOf(Collection::class, $products);
        $this->assertInstanceOf(Product::class, $product);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_create_a_product()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $product = new Product([
            'name'          => 'Latex',
            'incomeAccount' => 3000,
            'vatType'       => 'HIGH',
            'active'        => true, ]);
        $saved = $company->add($product);

        $this->assertInstanceOf(Product::class, $saved);
        $this->assertEquals('Latex', $product->name);
        $this->assertEquals(3000, $product->incomeAccount);
        $this->assertEquals('HIGH', $product->vatType);
        $this->assertTrue($product->active);
    }

    /**
     * @group dangerous
     */
    public function test_it_can_update_a_product()
    {
        $client = new FikenClient();

        $client->authenticate($_ENV['FIKEN_TEST_USERNAME'], $_ENV['FIKEN_TEST_PASSWORD']);
        $company = $client->setCompany($_ENV['FIKEN_TEST_ORGANIZATION_NUMBER']);

        $product = $company->products()->first();

        $product->name = 'Chips';

        $updated = $product->save();

        $this->assertEquals('Chips', $updated->name);
    }
}
