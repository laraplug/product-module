<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Attribute\Entities\Attribute;

class OptionGroup extends Model
{

    protected $table = 'product__option_groups';
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
     * Options
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Attribute
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
