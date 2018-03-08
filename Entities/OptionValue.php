<?php

namespace Modules\Product\Entities;

use Modules\Attribute\Entities\AttributeOption;

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
    protected $appends = [
        'label'
    ];

    /**
     * Option
     * @return mixed
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
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
