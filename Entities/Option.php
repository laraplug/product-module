<?php

namespace Modules\Product\Entities;

use Modules\Attribute\Entities\AttributeOption;

use Illuminate\Database\Eloquent\Model;

/**
 * Option Entity
 */
class Option extends Model
{

    protected $table = 'product__options';
    protected $fillable = [
        'key',
        'sku',
        'stock_enabled',
        'stock_quantity',
        'max_order_limit',
        'min_order_limit',
        'price_type',
        'price_value',
        'sort_order',
        'enabled',
    ];
    protected $appends = [
        'label'
    ];

    /**
     * Option Group
     * @return mixed
     */
    public function group()
    {
        return $this->belongsTo(OptionGroup::class);
    }

    /**
     * AttributeOption
     * @return mixed
     */
    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class);
    }

    public function getLabelAttribute()
    {
        return $this->attributeOption->label;
    }

}
