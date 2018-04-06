<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class AttributeOptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'product__attributeoption_translations';
}
