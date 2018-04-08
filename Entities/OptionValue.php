<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;

use Modules\Attribute\Entities\AttributeOption;

use Illuminate\Database\Eloquent\Model;

/**
 * OptionValue Entity
 */
class OptionValue extends Model
{
    use Translatable;

    protected $table = 'product__option_values';
    public $translatedAttributes = [
        'name',
    ];
    protected $fillable = [
        'code',
        'sku',
        'stock_enabled',
        'stock_quantity',
        'max_order_limit',
        'min_order_limit',
        'price_type',
        'price_value',
        'sort_order',
    ];

    /**
     * Option Group
     * @return mixed
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

}
