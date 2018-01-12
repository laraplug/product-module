<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class BasicProductTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        
    ];
    protected $table = 'product__basic_product_translations';
}
