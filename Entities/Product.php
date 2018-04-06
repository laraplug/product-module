<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Modules\Product\Traits\FeaturedImageTrait;
use Modules\Attribute\Traits\AttributableTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Product\Contracts\ProductInterface;
use Modules\Product\Repositories\ProductManager;
use Modules\Shop\Contracts\ShopProductInterface;
use Modules\Shop\Entities\Shop;
use Modules\Shop\Entities\ShopProduct;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;

/**
 * Product Entitiy
 */
class Product extends Model implements TaggableInterface, ProductInterface, ShopProductInterface
{
    use Translatable, TaggableTrait, NamespacedEntity, MediaRelation, FeaturedImageTrait, AttributableTrait;

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
     * Options
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        $pivotTable = (new AttributeProduct)->getTable();
        return $this->belongsToMany(Attribute::class, $pivotTable);
    }

    /**
     * Options
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
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
     * @param array $options
     */
    public function setOptionsAttribute(array $options = [])
    {
        foreach ($options as $slug => $optionGroupData) {
            if (empty(array_filter($optionGroupData))) {
                continue;
            }
            $attribute = $this->attributes()->where('slug', $slug)->first();
            if (!$attribute) {
                continue;
            }

            // Create option or enable it if exists
            $optionGroup = $this->options()->where('attribute_id', $attribute->id)->first();
            if ($optionGroup) {
                $optionGroup->fill($optionGroupData);
            } else {
                $optionGroup = $this->options()->create($optionGroupData);
                $optionGroup->attribute_id = $attribute->id;
            }
            $optionGroup->save();

            $options = array_get($optionGroupData, 'options', []);
            $optionIds = [];
            foreach ($options as $key => $data) {
                // Check if AttributeOption exists with given key
                $attributeOption = $attribute->options->where('key', $key)->first();
                $option = $optionGroup->options()->where('key', $key)->first();
                $data['key'] = $key;
                if ($option) {
                    $option->fill($data);
                } else {
                    // Import translation
                    if($attributeOption) {
                        $translations = $attributeOption->getTranslationsArray();
                        if(empty($translations)) $translations['label'] = $attributeOption->getLabel();
                        $data = array_merge($translations, $data);
                    }
                    // Create Data
                    $option = $optionGroup->options()->newModelInstance($data);
                    $option->option_group_id = $optionGroup->id;
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
    public function getOptions()
    {
        $options = $this->options->keyBy('attribute.slug');
        $options->map(function ($group) {
            $group->options = $group->options()->get()->keyBy('key');

            return $group;
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
