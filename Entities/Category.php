<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\NestableTrait;

class Category extends Model
{
    use Translatable, NestableTrait;

    protected $table = 'product__categories';
    public $translatedAttributes = [
        'name',
        'description',
    ];
    protected $fillable = [
        'parent_id',
        'position',
        'status',
    ];

    /**
     * For nested collection
     *
     * @var array
     */
    public $children = [];

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

}
