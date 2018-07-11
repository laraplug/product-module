<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Facades\Shop;

/**
 * OptionValue Entity
 */
class OptionValue extends Model
{

    protected $table = 'product__option_values';
    protected $fillable = [
        'name',
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
    // Default Value
    protected $attributes = [
        'stock_enabled' => 0,
        'stock_quantity' => 0,
        'max_order_limit' => 0,
        'max_order_limit' => 0,
        'price_type' => 'FIXED',
        'price_value' => 0,
        'sort_order' => 0,
    ];

    /**
     * @inheritDoc
     */
    public function getForeignKey()
    {
        return 'option_value_id';
    }

    /**
     * Option Group
     * @return mixed
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function getLabelAttribute()
    {
        $output = $this->name;
        if ($this->price_value == 0) {
            return $output;
        }
        $output .= ' (';
        $output .= $this->price_value > 0 ? '+': '';
        if ($this->price_type == 'FIXED') {
            $output .= Shop::money($this->price_value);
        } elseif ($this->price_type == 'PERCENTAGE') {
            $output .= $this->price_value . '%';
        }
        $output .= ')';

        return $output;
    }
}
