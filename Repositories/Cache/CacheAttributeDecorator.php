<?php

namespace Modules\Product\Repositories\Cache;

use Modules\Product\Repositories\AttributeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAttributeDecorator extends BaseCacheDecorator implements AttributeRepository
{
    public function __construct(AttributeRepository $attribute)
    {
        parent::__construct();
        $this->entityName = 'product.attributes';
        $this->repository = $attribute;
    }
}
