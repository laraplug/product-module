<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AttributeProduct extends Pivot
{

    protected $table = 'product__attribute_product';
    protected $fillable = [
        'attribute_id',
        'product_id',
    ];

}
