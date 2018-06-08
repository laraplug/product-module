<?php

namespace Modules\Product\Entities\Products;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;
use Modules\Shop\Contracts\ShopItemInterface;

/**
 * BundleItem
 */
class BundleItem extends Model implements ShopItemInterface
{
    protected $table = 'product__bundle_items';
    protected $fillable = [
        'product_id',
        'quantity',
        'option_values',
    ];
    protected $casts = [
        'option_values' => 'collection',
    ];
    protected $appends = [
        'product',
        'price',
        'total',
        'shipping_method_id',
        'shipping_storage_id',
    ];

    private $productOptions = null;

    /**
     * @inheritDoc
     */
    public function bundle()
    {
        return $this->belongsTo(Product::class, 'bundle_id');
    }

    /**
     * @inheritDoc
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @inheritDoc
     */
    public function getProductAttribute()
    {
        if (!$this->relationLoaded('product')) {
            $this->load('product');
        }

        return $this->getRelation('product');
    }

    /**
     * @inheritDoc
     */
    public function getQuantityAttribute()
    {
        return $this->getAttributeFromArray('quantity');
    }

    /**
     * @inheritDoc
     */
    public function getPriceAttribute()
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function getTotalAttribute()
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function getShippingMethodIdAttribute()
    {
        return $this->product->shipping_method_id;
    }

    /**
     * @inheritDoc
     */
    public function getShippingStorageIdAttribute()
    {
        return $this->product->shipping_storage_id ?: 0;
    }

    /**
     * @inheritDoc
     */
    public function getChildrenAttribute()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function toOrderItemArray(ShopItemInterface $parentItem = null)
    {
        $data = $this->toArray();
        // Inherit shop_id from parent
        if($parentItem) {
            $data['shop_id'] = $parentItem->shop_id;
        }
        return $data;
    }
}
