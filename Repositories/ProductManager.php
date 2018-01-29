<?php

namespace Modules\Product\Repositories;

use Modules\Product\Contracts\ProductInterface;

/**
 * Interface for Productables
 */
interface ProductManager
{
    /**
     * Returns all the registered entities
     * @return array
     */
    public function all();

    /**
     * Registers an entity
     * @param ProductInterface $entity
     * @return void
     */
    public function register(ProductInterface $entity);

    /**
     * Find entity by class namespace
     * @param string|null $entityClass
     * @return ProductInterface $entity
     */
    public function findByNamespace(string $entityNamespace);

    /**
     * Get first of entities
     * @return ProductInterface $entity
     */
    public function first();
}
