<?php

namespace Modules\Product\Products;

use Modules\Product\Entities\Product;

/**
 * Basic Type of Product
 */
class BasicProduct extends Product
{
    /**
     * @var string
     */
    protected static $entityNamespace = 'basic_product';

    /**
     * @inheritDoc
     */
    public function getEntityName()
    {
        return trans('product::basicproducts.title.basicproducts');
    }

    protected $systemAttributes = [
        'weight' => [
            'type' => 'input'
        ],
        'width' => [
            'type' => 'input'
        ],
        'height' => [
            'type' => 'input'
        ],
        'length' => [
            'type' => 'input'
        ]
    ];

}
