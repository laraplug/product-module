<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Exception;
use Modules\Order\Entities\OrderItem;

use Illuminate\Database\Eloquent\Model;
use Modules\Attribute\Traits\AttributableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Product\Contracts\ProductInterface;
use Modules\Product\Repositories\ProductManager;
use Modules\Product\Traits\FeaturedImageTrait;
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
        'code',
        'type',
        'category_id',
        'sku',
        'price',
        'sale_price',
        'stock_qty',
        'min_order_limit',
        'max_order_limit',
        'use_stock',
        'use_tax',
        'use_review',
        'status',
        'options',
    ];
    protected $casts = [
        'use_stock' => 'boolean',
        'use_tax' => 'boolean',
        'use_review' => 'boolean',
    ];
    protected $appends = [
        'options',
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
        if (!isset(static::$entityNamespace)) {
            throw new Exception('Product namespace not specified');
        }

        return static::$entityNamespace;
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
        static::saved(function ($model) use ($options) {
            $savedOptionIds = [];
            foreach ($options as $data) {
                if (empty(array_filter($data))) {
                    continue;
                }
                // Create option or enable it if exists
                $option = $this->options()->updateOrCreate([
                    'slug' => $data['slug'],
                ], $data);
                $savedOptionIds[] = $option->id;
            }
            $this->options()->whereNotIn('id', $savedOptionIds)->delete();
        });
    }

    /**
     * Get Options
     */
    public function getOptionsAttribute()
    {
        return $this->options()->orderBy('sort_order')->get();
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

    /**
     * @inheritDoc
     */
    public function getEntityFields()
    {
        return '';
    }

    /**
     * 주문후 보이는 Action뷰
     */
    public function getEntityActionFields(OrderItem $orderItem)
    {
        return '';
    }
}
