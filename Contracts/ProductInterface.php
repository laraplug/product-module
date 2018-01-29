<?php

namespace Modules\Product\Contracts;

/**
 * Interface for Productable
 */
interface ProductInterface
{

    /**
     * The Eloquent attribute entity name.
     * @var string
     */
    public static function getEntityNamespace();

    /**
     * Returns a human friendly name for the type.
     * @return string
     */
    public function getEntityName();

    /**
     * Returns the HTML for creating / editing an entity.
     * @return string
     */
    public function getFormField();

    /**
     * Returns the HTML for creating / editing an entity that has translatable values.
     * @param string $locale
     * @return string
     */
    public function getTranslatableFormField($locale);

}
