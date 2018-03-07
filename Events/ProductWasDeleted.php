<?php

namespace Modules\Product\Events;

use Modules\Media\Contracts\DeletingMedia;
use Modules\Product\Entities\Product;

class ProductWasDeleted implements DeletingMedia
{
    /**
     * @var Product
     */
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * @inheritDoc
     */
    public function getEntityId()
    {
        return $this->product->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getClassName()
    {
        return get_class($this->product);
    }
}
