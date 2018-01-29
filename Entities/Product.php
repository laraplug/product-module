<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Attribute\Contracts\AttributesInterface;
use Modules\Attribute\Traits\AttributableTrait;
use Modules\Product\Repositories\ProductManager;
use Modules\Tag\Traits\TaggableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Media\Image\Imagy;

/**
 * Product Entitiy
 */
class Product extends Model implements TaggableInterface, AttributesInterface
{
    use Translatable, TaggableTrait, NamespacedEntity, MediaRelation, AttributableTrait;

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
        'type',
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
    protected $translationForeignKey = 'product_id';

    public function getSmallThumbAttribute()
    {
        $file = $this->files()->first();
        if($file) {
            $imagy = app(Imagy::class);
            return $imagy->getThumbnail($file->path, 'smallThumb');
        }
        return null;
    }

    // Convert model into specific type (Returns Product if fail)
    public function newFromBuilder($attributes = [], $connection = null)
    {
        // Create Instance
        $productManager = app(ProductManager::class);
        $type = array_get((array) $attributes, 'type');
        $product = $type ? $productManager->findByNamespace($type) : null;
        $model = $product ? $product->newInstance([], true) : $this->newInstance([], true);

        $model->setRawAttributes((array) $attributes, true);
        $model->setConnection($connection ?: $this->getConnectionName());
        $model->fireModelEvent('retrieved', false);
        return $model;
    }

}
