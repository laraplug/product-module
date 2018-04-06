<?php

namespace Modules\Product\Repositories\Cache;

use Modules\Product\Repositories\AttributeOptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAttributeOptionDecorator extends BaseCacheDecorator implements AttributeOptionRepository
{
    public function __construct(AttributeOptionRepository $attributeoption)
    {
        parent::__construct();
        $this->entityName = 'product.attributeoptions';
        $this->repository = $attributeoption;
    }
}
