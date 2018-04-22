<?php

namespace Modules\Product\Entities\Products;


/**
 * Bundle Type of Product
 */
class BundleProduct extends BasicProduct
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
        $parentView = parent::getEntityFields();
        return $parentView . view('product::admin.bundleproducts.fields', ['product'=>$this]);
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
     * 번들상품 저장
     * Save Bundle Items
     */
     public function setItemsAttribute($items)
     {
         static::saved(function ($model) use ($items) {
             $this->items()->delete();
             foreach ($items as $data) {
                 // 상품ID는 필수
                 if (empty(array_filter($data)) || empty($data['product_id'])) {
                     continue;
                 }
                 // 옵션이 무조건 저장되도록 설정 (옵션없이 저장되면 옵션이 삭제되어야 함)
                 if(empty($data['options'])) $data['options'] = [];
                 $this->items()->create($data);
             }
         });
     }

}
