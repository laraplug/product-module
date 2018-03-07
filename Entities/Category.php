<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\NestableTrait;

class Category extends Model
{
    use Translatable, NestableTrait;

    protected $table = 'product__categories';
    protected $fillable = [
        'slug',
        'parent_id',
        'position',
        'status',
    ];
    public $translatedAttributes = [
        'name',
        'description',
    ];

    /**
     * Make the current menu item child of the given root item
     * @param Category $rootItem
     */
    public function makeChildOf(Category $rootItem)
    {
        $this->parent_id = $rootItem->id;
        $this->save();
    }

    /**
     * Check if the current menu item is the root
     * @return bool
     */
    public function isRoot()
    {
        return (bool) $this->parent_id;
    }


    /**
     * Parent Relation
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    /**
     * Siblings Relation
     * @return mixed
     */
    public function siblings()
    {
        return $this->hasMany(static::class, 'parent_id', 'parent_id');
    }

    /**
     * Children Relation
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

}
