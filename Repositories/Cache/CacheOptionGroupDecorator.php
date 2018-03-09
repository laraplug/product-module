<?php

namespace Modules\Product\Repositories\Cache;

use Modules\Product\Repositories\OptionGroupRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOptionGroupDecorator extends BaseCacheDecorator implements OptionGroupRepository
{
    public function __construct(OptionGroupRepository $optionGroup)
    {
        parent::__construct();
        $this->entityName = 'product.optiongroups';
        $this->repository = $optionGroup;
    }
}
