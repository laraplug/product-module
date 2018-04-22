<?php

namespace Modules\Product\Entities\Products;

use Modules\Shop\Repositories\ShippingMethodManager;

use Modules\Product\Entities\Product;

/**
 * Basic Type of Product
 */
class BasicProduct extends Product
{
    /**
     * @var string
     */
    protected static $entityNamespace = 'basic';

    /**
     * @inheritDoc
     */
    public function getEntityName()
    {
        return trans('product::basicproducts.title.basicproducts');
    }

    protected $systemAttributes = [

    ];

    /**
     * @inheritDoc
     */
    public function getEntityFields()
    {
        $shippingMethods = app(ShippingMethodManager::class)->all();
        return view('product::admin.basicproducts.fields', ['product'=>$this, 'shippingMethods'=>$shippingMethods]);
    }

}
