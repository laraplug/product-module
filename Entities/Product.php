<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Tag\Traits\TaggableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Media\Image\Imagy;

/**
 * Product Entitiy
 */
class Product extends Model implements TaggableInterface
{
    use Translatable, TaggableTrait, NamespacedEntity, MediaRelation;

    protected $table = 'product__products';

    /**
     * Translatable Attributes
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'description',
    ];
    protected $fillable = [
        'productable_type',
        'productable_id',
        'category_id',
        'sku',
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
        'small_thumb',
        'type'
    ];
    protected static $entityNamespace = 'laraplug/product';

    public function getSmallThumbAttribute()
    {
        $file = $this->files()->first();
        if($file) {
            $imagy = app(Imagy::class);
            return $imagy->getThumbnail($file->path, 'smallThumb');
        }
        return null;
    }

    /**
     * Get various types of product
     */
    public function productable()
    {
        return $this->morphTo();
    }

    public function getTypeAttribute()
    {
        $productable = $this->productable()->first();
        return $productable ? trans($productable->getTranslationName()) : '';
    }
}
