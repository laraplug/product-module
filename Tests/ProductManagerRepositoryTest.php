<?php

namespace Modules\Product\Tests;

use Modules\Product\Contracts\ProductableInterface;
use Modules\Product\Entities\BasicProduct;
use Modules\Product\Repositories\ProductableManager;
use Modules\Product\Traits\Productable;

class ProductableManagerRepositoryTest extends BaseTestCase
{
    /**
     * @var ProductableManager
     */
    private $productManager;

    public function setUp()
    {
        parent::setUp();

        $this->productManager = app(ProductableManager::class);
    }

    /** @test */
    public function it_initialises_empty_array()
    {
        $this->assertEquals([new BasicProduct()], $this->productManager->all());
    }

    /** @test */
    public function it_adds_items_to_array()
    {
        $this->productManager->register(new TestModel());

        $this->assertCount(2, $this->productManager->all());
    }
}

class TestModel implements ProductableInterface
{
    use Productable;
}
