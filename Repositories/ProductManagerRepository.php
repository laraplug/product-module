<?php

namespace Modules\Product\Repositories;

use Modules\Product\Contracts\ProductInterface;

/**
 * Repository for various productable entities
 */
class ProductManagerRepository implements ProductManager
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

    public function register(ProductInterface $entity)
    {
        $this->entities[] = $entity;
    }

    public function findByNamespace(string $entityNamespace)
    {
        foreach ($this->entities as $entity) {
            if($entity->getEntityNamespace() == $entityNamespace) return $entity;
        }
        return null;
    }

    public function first()
    {
        return isset($this->entities[0]) ? $this->entities[0] : null;
    }
}
