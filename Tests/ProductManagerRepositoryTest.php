<?php

namespace Modules\Product\Tests;

use Modules\Core\Traits\NamespacedEntity;
use Modules\Product\Contracts\ProductInterface;
use Modules\Product\Products\BasicProduct;
use Modules\Product\Repositories\ProductManager;

class ProductManagerRepositoryTest extends BaseTestCase
{
    /**
     * @var ProductManager
     */
    private $productManager;

    public function setUp()
    {
        parent::setUp();

        $this->productManager = app(ProductManager::class);
    }

    /** @test */
    public function it_initialises_empty_array()
    {
        $this->assertEquals([new BasicProduct()], $this->productManager->all());
    }

    /** @test */
    public function it_adds_items_to_array()
    {
        $this->productManager->registerEntity(new TestModel());

        $this->assertCount(2, $this->productManager->all());
    }
}

class TestModel implements ProductInterface
{
    use NamespacedEntity;

    protected static $entityNamespace = 'laraplug/testproduct';

    public function getEntityName()
    {
        return 'TestProduct';
    }
}
