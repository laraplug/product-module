<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class OptionTranslation extends Model
{
    protected $table = 'product__option_translations';
    public $timestamps = false;
    protected $fillable = [
        'label',
    ];
}
