<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Storage;

class ProductStorage extends Pivot
{
    protected $table = 'product__product_storage';
    protected $fillable = [
        'product_id',
        'storage_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
}
