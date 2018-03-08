<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Attribute\Contracts\AttributesInterface;
use Modules\Attribute\Traits\Attributable;
use Modules\Product\Contracts\ProductInterface;
use Modules\Product\Repositories\ProductManager;
use Modules\Tag\Traits\TaggableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Media\Image\Imagy;

/**
 * Product Entitiy
 */
class Product extends Model implements TaggableInterface, AttributesInterface, ProductInterface
{
    use Translatable, TaggableTrait, NamespacedEntity, MediaRelation, Attributable;

    protected $table = 'product__products';

    protected $fillable = [
      'type',
      'category_id',
      'sku',
      'currency_code',
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
      'currency',
      'featured_image',
      'small_thumb',
      'medium_thumb',
      'large_thumb',
    ];

    /**
     * @inheritDoc
     */
    public function getForeignKey()
    {
        return 'product_id';
    }

    /**
     * @var string
     */
    protected static $entityNamespace = 'laraplug/product';

    /**
     * @var string
     */
    protected $translationModel = ProductTranslation::class;

    /**
     * Translatable Attributes
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'description',
    ];

    /**
     * @var array
     */
    protected static $systemAttributes = [];

    /**
     * @inheritDoc
     */
    public function getTypeAttribute($value)
    {
        return static::$entityNamespace;
    }

    /**
     * Returns thumnail url
     */
    public function getFeaturedImageAttribute()
    {
        if($file = $this->filesByZone('featured_image')->first()) {
            return $file->path;
        }
        return Module::asset('product:images/placeholder.jpg');
    }

    /**
     * Returns thumnail url
     */
    public function getSmallThumbAttribute()
    {
        if($file = $this->filesByZone('featured_image')->first()) {
            return app(Imagy::class)->getThumbnail($file->path, 'smallThumb');
        }
        return Module::asset('product:images/placeholder_smallThumb.jpg');
    }

    /**
     * Returns thumnail url
     */
    public function getMediumThumbAttribute()
    {
        if($file = $this->filesByZone('featured_image')->first()) {
            return app(Imagy::class)->getThumbnail($file->path, 'mediumThumb');
        }
        return Module::asset('product:images/placeholder_mediumThumb.jpg');
    }

    /**
     * Returns thumnail url
     */
    public function getLargeThumbAttribute()
    {
        if($file = $this->filesByZone('featured_image')->first()) {
            return app(Imagy::class)->getThumbnail($file->path, 'largeThumb');
        }
        return Module::asset('product:images/placeholder_largeThumb.jpg');
    }

    /**
     * Returns currency code
     */
    public function getCurrencyCodeAttribute($value)
    {
        $defaultCode = Lang::has('product::products.currency.code') ? trans('product::products.currency.code') : 'USD';
        return $value ? $value : $defaultCode;
    }

    /**
     * Returns currency object
     */
    public function getCurrencyAttribute($value)
    {
        return currency($this->currency_code)->toArray()[$this->currency_code];
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

    /**
     * Options
     * @return HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Category
     * @return HasOne
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Save Options
     * @param array $options
     */
    public function setOptions(array $options = [])
    {
        foreach ($options as $slug => $optionData) {
            if(empty(array_filter($optionData))) continue;
            $attribute = $this->attributes()->where('slug', $slug)->first();
            if(!$attribute) continue;

            // Create option or enable it if exists
            $option = $this->options()->where('attribute_id', $attribute->id)->first();
            if($option) {
                $option->fill($optionData);
            }
            else {
                $option = $this->options()->create($optionData);
                $option->attribute_id = $attribute->id;
            }
            $option->save();

            $optionValues = array_get($optionData, 'values', []);
            $optionValueIds = [];
            foreach ($optionValues as $key => $data) {
                // Check if AttributeOption exists with given key
                $baseOptionValue = $option->attribute->options()->where('key', $key)->first();
                if(!$baseOptionValue) continue;

                $optionValue = $option->values()->where('key', $key)->first();
                $data['key'] = $key;
                if($optionValue) {
                    $optionValue->fill($data);
                }
                else {
                  $optionValue = $option->values()->newModelInstance($data);
                  $optionValue->option_id = $option->id;
                  // This is for getting translation
                  $optionValue->attribute_option_id = $baseOptionValue->id;
                }
                $optionValue->save();

                $optionValueIds[] = $optionValue->getKey();
            }
            $option->values()->whereNotIn('id', $optionValueIds)->delete();
        }
    }

    /**
     * Get Options key by key
     */
    public function getOptions()
    {
        $options = $this->options->keyBy('attribute.slug');
        $options->map(function($option) {
            $option->values = $option->values()->get()->keyBy('key');
            return $option;
        });
        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function removeOptions()
    {
        return $this->options()->delete();
    }

    /**
     * @inheritDoc
     */
    public function getEntityName()
    {
        return trans('product::products.title.products');
    }

}
