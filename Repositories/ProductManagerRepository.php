<?php

namespace Modules\Product\Repositories;

use Modules\Attribute\Repositories\AttributesManager;
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

    public function registerEntity(ProductInterface $entity)
    {
        // Register Product to Attribute Module automatically
        app(AttributesManager::class)->registerEntity($entity);

        $this->entities[$entity->getEntityNamespace()] = $entity;
    }

    public function findByNamespace(string $entityNamespace)
    {
        return array_get($this->entities, $entityNamespace, null);
    }

    public function first()
    {
        return collect($this->entities)->first();
    }
}
