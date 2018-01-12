<?php

namespace Modules\Product\Contracts;

/**
 * Interface for Product Storing
 */
interface StoringProduct
{
    /**
     * Return the productable type
     * @return string
     */
    public function getProductableType();

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity();

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData();
}
