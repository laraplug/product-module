<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use Translatable;

    protected $table = 'product__options';
    public $translatedAttributes = [
        'name',
    ];
    protected $fillable = [
        'code',
        'sort_order',
        'required',
        'enabled',
    ];
    protected $casts = [
        'sort_order' => 'integer',
        'enabled' => 'integer',
    ];

    /**
     * Options
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }

}
