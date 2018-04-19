<?php

namespace Modules\Product\Entities\Products;

use Modules\Shop\Facades\Shop;

use Modules\Shop\Contracts\ShopItemInterface;

use Modules\Product\Entities\Option;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

/**
 * BundleItem
 */
class BundleItem extends Model implements ShopItemInterface
{
    protected $table = 'product__bundle_items';
    protected $fillable = [
        'product_id',
        'quantity',
        'options',
    ];
    protected $casts = [
        'options' => 'array',
    ];
    protected $appends = [
        'options',
        'product',
        'price',
        'total',
    ];

    /**
     * @inheritDoc
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @inheritDoc
     */
    public function options()
    {
        return $this->hasMany(BundleItemOption::class, 'bundle_item_id');
    }

    /**
     * @inheritDoc
     */
    public function getProductAttribute()
    {
        return $this->product()->first();
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
    public function getOptionsAttribute()
    {
        return $this->options()->get();
    }

    /**
     * Save Options
     * @param array $options
     */
    public function setOptionsAttribute(array $options = [])
    {
        static::saved(function ($model) use ($options) {
            $savedOptionIds = [];
            foreach ($options as $slug => $value) {
                if (empty($value)) {
                    continue;
                }
                // Create option or enable it if exists
                $productOption = $this->product->options()->where('slug', $slug)->first();
                $option = $this->options()->updateOrCreate([
                    'product_option_id' => $productOption->id,
                ], ['value' => $value]);
                $savedOptionIds[] = $option->id;
            }
            $this->options()->whereNotIn('id', $savedOptionIds)->delete();
        });
    }

    /**
     * @inheritDoc
     */
    public function getChildrenAttribute()
    {
        return [];
    }

}
