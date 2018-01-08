<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Tag\Traits\TaggableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Media\Image\Imagy;

class Product extends Model implements TaggableInterface
{
    use Translatable, TaggableTrait, NamespacedEntity, MediaRelation;

    protected $table = 'product__products';
    public $translatedAttributes = [
        'name',
        'description',
    ];
    protected $fillable = [
        'category_id',
        'type',
        'sku',
        'weight',
        'height',
        'width',
        'length',
        'regular_price',
        'sale_price',
        'use_stock',
        'stock_qty',
        'use_tax',
        'use_review',
        'status',
    ];
    protected $casts = [
        'use_stock' => 'boolean',
        'use_tax' => 'boolean',
        'use_review' => 'boolean',
    ];
    protected $appends = [
        'small_thumb'
    ];
    protected static $entityNamespace = 'asgardcms/product';

    public function getSmallThumbAttribute()
    {
        $file = $this->files()->first();
        if($file) {
            $imagy = app(Imagy::class);
            return $imagy->getThumbnail($file->path, 'smallThumb');
        }
        return null;
    }
}
