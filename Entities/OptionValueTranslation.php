<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class OptionValueTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
    protected $table = 'product__option_value_translations';
}
