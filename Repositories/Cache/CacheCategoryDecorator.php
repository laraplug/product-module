<?php

namespace Modules\Product\Repositories\Cache;

use Modules\Product\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'product.categories';
        $this->repository = $category;
    }
}
