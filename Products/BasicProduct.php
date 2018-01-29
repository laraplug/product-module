<?php

namespace Modules\Product\Products;

use Modules\Product\Contracts\ProductInterface;
use Modules\Product\Entities\Product;
use Modules\Product\Traits\Productable;

/**
 * Basic Type of Product
 */
class BasicProduct extends Product implements ProductInterface
{
    use Productable;
    /**
     * @var string
     */
    protected static $entityNamespace = 'laraplug/basicproduct';

    /**
     * @inheritDoc
     */
    public function getEntityName()
    {
        return trans('product::basicproducts.title.basicproducts');
    }

}
