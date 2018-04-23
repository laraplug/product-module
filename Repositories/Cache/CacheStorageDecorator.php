<?php

namespace Modules\Product\Repositories\Cache;

use Modules\Product\Repositories\StorageRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheStorageDecorator extends BaseCacheDecorator implements StorageRepository
{
    public function __construct(StorageRepository $storage)
    {
        parent::__construct();
        $this->entityName = 'product.storages';
        $this->repository = $storage;
    }
}
