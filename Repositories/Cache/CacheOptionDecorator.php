<?php

namespace Modules\Product\Repositories\Cache;

use Modules\Product\Repositories\OptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOptionDecorator extends BaseCacheDecorator implements OptionRepository
{
    public function __construct(OptionRepository $option)
    {
        parent::__construct();
        $this->entityName = 'product.options';
        $this->repository = $option;
    }
}
