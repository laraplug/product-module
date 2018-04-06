<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class AttributeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
    protected $table = 'product__attribute_translations';
}
