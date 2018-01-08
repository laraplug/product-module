<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
    ];
    protected $table = 'product__category_translations';
}
