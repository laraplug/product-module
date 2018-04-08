<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Modules\Product\Contracts\OptionInterface;
use Modules\Product\Repositories\OptionManager;
use Illuminate\Database\Eloquent\Model;

class Option extends Model implements OptionInterface
{
    use Translatable;

    protected $table = 'product__options';
    public $translatedAttributes = [
        'name',
    ];
    protected $fillable = [
        'slug',
        'type',
        'sort_order',
        'required',
        'values',
    ];
    protected $appends = [
        'values',
        'type',
        'type_name',
        'is_collection',
    ];

    /**
     * @inheritDoc
     */
    public function getForeignKey()
    {
        return 'option_id';
    }

    /**
     * @var string
     */
    protected $translationModel = OptionTranslation::class;

    // Convert model into specific type (Returns Product if fail)
    public function newFromBuilder($attributes = [], $connection = null)
    {
        // Create Instance
        $manager = app(OptionManager::class);
        $type = array_get((array) $attributes, 'type');
        $entity = $type ? $manager->findByNamespace($type) : null;
        $model = $entity ? $entity->newInstance([], true) : $this->newInstance([], true);

        $model->setRawAttributes((array) $attributes, true);
        $model->setConnection($connection ?: $this->getConnectionName());
        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    /**
     * @var string
     */
    protected $entityNamespace = '';

    /**
     * @inheritDoc
     */
    public function getTypeAttribute()
    {
        return $this->entityNamespace;
    }

    /**
     * @inheritDoc
     */
    public function getTypeNameAttribute()
    {
        if(!$this->type) return '';
        return trans("product::options.types.{$this->type}");
    }

    /**
     * @inheritDoc
     */
    public function getIsCollectionAttribute()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getFormField($elemAttributes = null)
    {
        if(!$this->type) return '';
        $option = $this;
        return view("product::admin.options.types.{$this->type}", compact('option', 'elemAttributes'));
    }

    /**
     * Options
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }

    /**
     * Save Options
     * @param array $values
     */
    public function setValuesAttribute(array $values = [])
    {
        static::saved(function ($model) use ($values) {
            $savedIds = [];
            foreach ($values as $data) {
                if (empty(array_filter($data))) {
                    continue;
                }
                // Create option or enable it if exists
                $value = $this->values()->updateOrCreate([
                    'code' => $data['code'],
                ], $data);
                $savedIds[] = $value->id;
            }
            $this->values()->whereNotIn('id', $savedIds)->delete();
        });
    }

    /**
     * Get Values
     */
    public function getValuesAttribute()
    {
        return $this->values()->get();
    }

}
