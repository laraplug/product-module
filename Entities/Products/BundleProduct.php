<?php

namespace Modules\Product\Entities\Products;

use Modules\Product\Entities\Product;

/**
 * Bundle Type of Product
 */
class BundleProduct extends Product
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable[] = 'items';
    }

    /**
     * @var string
     */
    protected static $entityNamespace = 'bundle';

    /**
     * @inheritDoc
     */
    public function getEntityName()
    {
        return trans('product::bundleproducts.title.bundleproducts');
    }

    /**
     * @inheritDoc
     */
    public function getEntityFields()
    {
        return view('product::admin.bundleproducts.fields', ['product'=>$this]);
    }

    /**
     * Product items of bundle
     * @return mixed
     */
    public function items()
    {
        return $this->hasMany(BundleItem::class, 'bundle_id');
    }

    /**
     * Save Bundle Items
     */
     public function setItemsAttribute($items)
     {
         static::saved(function ($model) use ($items) {
             $savedIds = [];
             foreach ($items as $data) {
                 if (empty(array_filter($data)) || empty($data['product_id'])) {
                     continue;
                 }
                 // Create option or enable it if exists
                 $item = $this->items()->updateOrCreate([
                     'product_id' => $data['product_id']
                 ], $data);
                 $savedIds[] = $item->id;
             }

             if(!empty($savedIds)) {
                 $this->items()->whereNotIn('id', $savedIds)->delete();
             }
         });
     }

}
