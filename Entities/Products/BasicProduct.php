<?php

namespace Modules\Product\Entities\Products;

use Modules\Shop\Repositories\ShippingMethodManager;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Storage;
use Modules\Product\Entities\ProductStorage;
use Modules\Product\Repositories\StorageRepository;

/**
 * Basic Type of Product
 */
class BasicProduct extends Product
{

    public function __construct(array $attributes = [])
    {
        $this->fillable[] = 'shipping_method_id';
        $this->fillable[] = 'shipping_storage_id';

        parent::__construct($attributes);
    }

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
     * 저장소별 상품재고
     * Get Storages Stocks belongs to Product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function storages()
    {
        $pivotTable = (new ProductStorage)->getTable();
        return $this->belongsToMany(Storage::class, $pivotTable);
    }

    /**
     * 배송준비를 진행하는 저장소id
     * Get Shipping Storage belongs to Product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shippingStorage()
    {
        return $this->belongsTo(Storage::class, 'shipping_storage_id');
    }

    /**
     * @inheritDoc
     */
    public function getEntityFields()
    {
        $shippingMethods = app(ShippingMethodManager::class)->all();
        $storages = app(StorageRepository::class)->all();
        return view('product::admin.basicproducts.fields', [
            'product' => $this,
            'shippingMethods' => $shippingMethods,
            'storages' => $storages
        ]);
    }

}
