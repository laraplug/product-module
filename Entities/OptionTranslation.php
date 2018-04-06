<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class OptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
    ];
    protected $table = 'product__option_translations';
}
