<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Product\Contracts\ProductInterface;
use Modules\Product\Repositories\AttributeManager;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use Translatable, NamespacedEntity;

    protected $table = 'product__attributes';
    public $translatedAttributes = [
        'name',
    ];
    protected $fillable = [
        'code',
        'type',
        'is_enabled',
        'is_system',
        'is_required',
        'is_translatable',
    ];

    /**
     * @inheritDoc
     */
    public function getForeignKey()
    {
        return 'attribute_id';
    }

    /**
     * @var string
     */
    protected $translationModel = AttributeTranslation::class;

    // Convert model into specific type (Returns Product if fail)
    public function newFromBuilder($attributes = [], $connection = null)
    {
        // Create Instance
        $manager = app(AttributeManager::class);
        $type = array_get((array) $attributes, 'type');
        $attribute = $type ? $manager->findByNamespace($type) : null;
        $model = $attribute ? $attribute->newInstance([], true) : $this->newInstance([], true);

        $model->setRawAttributes((array) $attributes, true);
        $model->setConnection($connection ?: $this->getConnectionName());
        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    public function getIsTranslatableAttribute()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getFormField(ProductInterface $entity)
    {
        $attribute = $this;
        return view("product::admin.attributes.normal.{$this->type}", compact('attribute', 'entity'));
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslatableFormField(ProductInterface $entity, $locale)
    {
        $attribute = $this;
        return view("product::admin.attributes.translatable.{$this->type}", compact('attribute', 'entity', 'locale'));
    }

}
