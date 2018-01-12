<?php

namespace Modules\Product\Events;

use Modules\Media\Contracts\StoringMedia;
use Modules\Product\Contracts\StoringProduct;
use Modules\Product\Entities\Product;

/**
 * Event when product was created
 */
class ProductWasCreated implements StoringMedia, StoringProduct
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Product
     */
    public $product;

    public function __construct(Product $product, array $data)
    {
        $this->data = $data;
        $this->product = $product;
    }

    public function getProductableType()
    {
        return $this->product->productable_type;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->product;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
