<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Attribute\Entities\Attribute;

class Option extends Model
{

    protected $table = 'product__options';
    protected $fillable = [
        'sort_order',
        'required',
        'enabled',
    ];
    protected $appends = [
        'name',
        'key'
    ];
    protected $casts = [
        'enabled' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Option Values
     * @return HasMany
     */
    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }

    /**
     * Attribute
     * @return BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function setEnabledAttribute($value)
    {
        $this->attributes['enabled'] = $value ? 1 : 0;
    }

    public function getNameAttribute()
    {
        return $this->attribute->name;
    }

    public function getKeyAttribute()
    {
        return $this->attribute->key;
    }

}
