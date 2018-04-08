<?php

namespace Modules\Product\Repositories;

use Modules\Product\Contracts\OptionInterface;

/**
 * Interface for Options
 */
interface OptionManager
{
    /**
     * Returns all the registered entities
     * @return array
     */
    public function all();

    /**
     * Registers an entity
     * @param OptionInterface $entity
     * @return void
     */
    public function registerEntity(OptionInterface $entity);

    /**
     * Find entity by class namespace
     * @param string $entityNamespace
     * @return OptionInterface $entity
     */
    public function findByNamespace(string $entityNamespace);

    /**
     * Get first of entities
     * @return OptionInterface $entity
     */
    public function first();
}
