<?php

namespace Modules\Product\Events;

use Modules\Product\Entities\Product;

class ProductWasDeleted
{
    /**
     * @var Product
     */
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }
}
