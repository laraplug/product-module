<?php

namespace Modules\Product\Repositories;

use Modules\Product\Entities\Attribute;

/**
 * @inheritDoc
 */
final class AttributeManagerRepository implements AttributeManager
{
    /**
     * @var array
     */
    private $entities = [];

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->entities;
    }

    /**
     * @inheritDoc
     */
    public function registerEntity(Attribute $entity)
    {
        $this->entities[$entity->type] = $entity;
    }

    /**
     * @inheritDoc
     */
    public function findByNamespace(string $entityNamespace)
    {
        return array_get($this->entities, $entityNamespace, null);
    }

    /**
     * @inheritDoc
     */
    public function first()
    {
        return collect($this->entities)->first();
    }

}
