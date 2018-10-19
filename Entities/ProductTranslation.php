<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'content',
        'description',
    ];
    protected $table = 'product__product_translations';
}
