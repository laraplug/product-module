<?php

namespace Modules\Product\Repositories\Cache;

use Modules\Product\Repositories\BasicProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBasicProductDecorator extends BaseCacheDecorator implements BasicProductRepository
{
    public function __construct(BasicProductRepository $basicproduct)
    {
        parent::__construct();
        $this->entityName = 'product.basicproducts';
        $this->repository = $basicproduct;
    }
}
