<?php

namespace Modules\Product\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;
use Modules\Product\Entities\Product;

class ProductIsUpdating extends AbstractEntityHook implements EntityIsChanging
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product, array $attributes)
    {
        $this->product = $product;
        parent::__construct($attributes);
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
