<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Product\Contracts\OptionInterface;
use Modules\Product\Repositories\OptionManager;
use Illuminate\Database\Eloquent\Model;

class Option extends Model implements OptionInterface
{
    use Translatable, NamespacedEntity;

    protected $table = 'product__options';
    public $translatedAttributes = [
        'name',
        'description',
    ];
    protected $fillable = [
        'slug',
        'type',
        'sort_order',
        'is_required',
        'is_hidden',
        'values',
    ];
    protected $appends = [
        'values',
        'type',
        'type_name',
        'is_collection',
        'is_system',
        'is_readonly',
        'form_field',
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
    protected static $entityNamespace = '';

    /**
     * @inheritDoc
     */
    public function getTypeAttribute()
    {
        return static::$entityNamespace;
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
    public function getIsCollectionAttribute(): int
    {
        return false;
    }

    /**
     * 시스템에서 생성하는 옵션인지 여부
     * @return int
     */
    public function getIsSystemAttribute(): int
    {
        return isset($this->attributes['is_system']) ? $this->attributes['is_system'] : false;
    }

    /**
     * 생성된 이후 관리자가 수정할수 있는지 여부
     * @return int
     */
    public function getIsReadonlyAttribute(): int
    {
        return isset($this->attributes['is_readonly']) ? $this->attributes['is_readonly'] : false;
    }

    /**
     * Form Field View name
     * @var string
     */
    protected $formFieldView = "";

    /**
     * {@inheritDoc}
     */
    public function getFormField($elemAttributes = [])
    {
        if(!$this->type || !$this->formFieldView) return '';
        if(empty($elemAttributes['name'])) $elemAttributes['name'] = "options[{$this->slug}]";
        return view($this->formFieldView, ['option' => $this, 'elemAttributes' => $elemAttributes]);
    }

    /**
     * @var string
     */
    protected $valueModel = OptionValue::class;

    /**
     * Option Values
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany($this->valueModel);
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

    /**
     * Get FormField
     */
    public function getFormFieldAttribute(): string
    {
        return $this->getFormField(['class' => 'form-control']);
    }

}
