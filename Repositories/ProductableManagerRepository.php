<?php

namespace Modules\Product\Repositories;

use Modules\Product\Contracts\ProductableInterface;

/**
 * Repository for various productable entities
 */
class ProductableManagerRepository implements ProductableManager
{
    /**
     * Array of registered entities.
     * @var array
     */
    private $entities = [];

    public function all()
    {
        return $this->entities;
    }

    public function register(ProductableInterface $entity)
    {
        $this->entities[] = $entity;
    }

    public function findByClass(string $entityClass = null)
    {
        foreach ($this->entities as $item) {
            if($item->getClassName() == $entityClass) return $item;
        }
        return null;
    }

    public function first()
    {
        return isset($this->entities[0]) ? $this->entities[0] : null;
    }
}
