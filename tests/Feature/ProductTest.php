<?php

namespace audunru\FikenClient\Tests\Feature;

use audunru\FikenClient\Models\Product;
use audunru\FikenClient\Tests\ClientTestCase;
use Illuminate\Support\Collection;

class ProductTest extends ClientTestCase
{
    /**
     * @group dangerous
     */
    public function testItCanRetrieveProducts()
    {
        $products = $this->company->products();
        $product = $products->first();

        $this->assertInstanceOf(Collection::class, $products);
        $this->assertInstanceOf(Product::class, $product);
    }

    /**
     * @group dangerous
     */
    public function testItCanCreateAProduct()
    {
        $product = new Product([
            'name'          => 'Latex',
            'incomeAccount' => 3000,
            'vatType'       => 'HIGH',
            'active'        => true, ]);
        $saved = $this->company->add($product);

        $this->assertInstanceOf(Product::class, $saved);
        $this->assertEquals('Latex', $product->name);
        $this->assertEquals(3000, $product->incomeAccount);
        $this->assertEquals('HIGH', $product->vatType);
        $this->assertTrue($product->active);
    }

    /**
     * @group dangerous
     */
    public function testItCanUpdateAProduct()
    {
        $product = $this->company->products()->first();

        $product->name = 'Chips';

        $updated = $product->save();

        $this->assertEquals('Chips', $updated->name);
    }
}
