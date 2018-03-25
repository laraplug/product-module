<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Modules\Shop\Entities\Shop;
use Modules\Shop\Entities\ShopProduct;

use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Model;
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
      'price',
      'sale_price',
      'use_stock',
      'stock_qty',
      'min_order_limit',
      'max_order_limit',
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
     * @var array
     */
    protected $systemAttributes = [];

    public static $zone = 'featured_image';

    public function images()
    {
        return $this->filesByZone(static::$zone);
    }

    public function shops()
    {
        $pivotTable = (new ShopProduct)->getTable();
        return $this->belongsToMany(Shop::class, $pivotTable);
    }

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
        if($image = $this->images->first()) {
            return $image->path;
        }
        return Module::asset('product:images/placeholder.jpg');
    }

    /**
     * Returns thumnail url
     */
    public function getSmallThumbAttribute()
    {
        if($image = $this->images->first()) {
            return app(Imagy::class)->getThumbnail($image->path, 'smallThumb');
        }
        return Module::asset('product:images/placeholder_smallThumb.jpg');
    }

    /**
     * Returns thumnail url
     */
    public function getMediumThumbAttribute()
    {
        if($image = $this->images->first()) {
            return app(Imagy::class)->getThumbnail($image->path, 'mediumThumb');
        }
        return Module::asset('product:images/placeholder_mediumThumb.jpg');
    }

    /**
     * Returns thumnail url
     */
    public function getLargeThumbAttribute()
    {
        if($image = $this->images->first()) {
            return app(Imagy::class)->getThumbnail($image->path, 'largeThumb');
        }
        return Module::asset('product:images/placeholder_largeThumb.jpg');
    }

    /**
     * Options
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function optionGroups()
    {
        return $this->hasMany(OptionGroup::class);
    }

    /**
     * Category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Save Options
     * @param array $optionGroups
     */
    public function setOptionGroups(array $optionGroups = [])
    {
        foreach ($optionGroups as $slug => $optionGroupData) {
            if(empty(array_filter($optionGroupData))) continue;
            $attribute = $this->attributes()->where('slug', $slug)->first();
            if(!$attribute) continue;

            // Create option or enable it if exists
            $optionGroup = $this->optionGroups()->where('attribute_id', $attribute->id)->first();
            if($optionGroup) {
                $optionGroup->fill($optionGroupData);
            }
            else {
                $optionGroup = $this->optionGroups()->create($optionGroupData);
                $optionGroup->attribute_id = $attribute->id;
            }
            $optionGroup->save();

            $options = array_get($optionGroupData, 'options', []);
            $optionIds = [];
            foreach ($options as $key => $data) {
                // Check if AttributeOption exists with given key
                $attributeOption = $optionGroup->attribute->options()->where('key', $key)->first();
                if(!$attributeOption) continue;

                $option = $optionGroup->options()->where('key', $key)->first();
                $data['key'] = $key;
                if($option) {
                    $option->fill($data);
                }
                else {
                  $option = $optionGroup->options()->newModelInstance($data);
                  $option->option_group_id = $optionGroup->id;
                  // This is for getting translation
                  $option->attribute_option_id = $attributeOption->id;
                }
                $option->save();

                $optionIds[] = $option->getKey();
            }
            $optionGroup->options()->whereNotIn('id', $optionIds)->delete();
        }
    }

    /**
     * Get Options key by key
     */
    public function getOptionGroups()
    {
        $optionGroups = $this->optionGroups->keyBy('attribute.slug');
        $optionGroups->map(function($group) {
            $group->options = $group->options()->get()->keyBy('key');
            return $group;
        });
        return $optionGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function removeOptionGroups()
    {
        return $this->optionGroups()->delete();
    }

    /**
     * @inheritDoc
     */
    public function getEntityName()
    {
        return trans('product::products.title.products');
    }

}
