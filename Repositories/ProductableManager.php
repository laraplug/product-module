<?php

namespace Modules\Product\Repositories;

use Modules\Product\Contracts\ProductableInterface;

/**
 * Interface for Productables
 */
interface ProductableManager
{
    /**
     * Returns all the registered entities
     * @return array
     */
    public function all();

    /**
     * Registers an entity
     * @param ProductableInterface $entity
     * @return void
     */
    public function register(ProductableInterface $entity);

    /**
     * Find entity by class namespace
     * @param string|null $entityClass
     * @return ProductableInterface $entity
     */
    public function findByClass(string $entityClass = null);

    /**
     * Get first of entities
     * @return ProductableInterface $entity
     */
    public function first();
}
