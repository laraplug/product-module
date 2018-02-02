<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * OptionValue Entity
 */
class OptionValue extends Model
{

    protected $table = 'product__option_values';
    protected $fillable = [
        'key',
        'sku',
        'stock_enabled',
        'stock_quantity',
        'price_type',
        'price_value',
        'sort_order',
        'enabled',
    ];
}
