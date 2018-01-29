<?php

namespace Modules\Product\Traits;
use Modules\Attribute\Repositories\AttributesManager;

/**
 * Trait to support implementing Modules\Product\Contracts\ProductContract
 */
trait Productable
{

    /**
     * @inheritDoc
     */
    public function getEntityName()
    {
        return get_called_class();
    }

    /**
     * @inheritDoc
     */
    public function getFormField()
    {
        $form = is_callable('parent::getFormField') ? parent::getFormField() : '';
        $attributesManager = $this->app[AttributesManager::class];
        foreach ($this->attributes()->get() as $attribute) {
            $form .= $attributesManager->getEntityFormField($attribute, $this);
        }
        return $form;
    }

    /**
     * @inheritDoc
     */
    public function getTranslatableFormField($locale)
    {
        $form = is_callable('parent::getTranslatableFormField') ? parent::getTranslatableFormField() : '';
        $attributesManager = $this->app[AttributesManager::class];
        foreach ($this->attributes()->get() as $attribute) {
            $form .= $attributesManager->getTranslatableEntityFormField($attribute, $this, $locale);
        }
        return $form;
    }
}
