<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{

    protected $table = 'product__storages';
    protected $fillable = [
        'name',
        'description',
    ];
}
