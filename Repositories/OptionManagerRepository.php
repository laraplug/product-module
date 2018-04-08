<?php

namespace Modules\Product\Repositories;

use Modules\Product\Contracts\OptionInterface;

/**
 * Repository for various option entities
 */
class OptionManagerRepository implements OptionManager
{
    /**
     * Array of registered entities.
     * @var array
     */
    private $entities = [];

    public function all()
    {
        return collect($this->entities);
    }

    public function registerEntity(OptionInterface $entity)
    {
        $this->entities[$entity->type] = $entity;
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
