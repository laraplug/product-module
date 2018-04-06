<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    use Translatable;

    protected $table = 'product__attributeoptions';
    public $translatedAttributes = [];
    protected $fillable = [];
}
