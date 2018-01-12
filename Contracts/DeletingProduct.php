<?php

namespace Modules\Product\Contracts;

/**
 * Interface for Product Deleting
 */
interface DeletingProduct
{
    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId();

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName();
}
