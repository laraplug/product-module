<?php

namespace Modules\Product\Contracts;

/**
 * Interface for Productable
 */
interface ProductableInterface
{

    /**
     * Returns the entity class name.
     *
     * @return string
     */
    public static function getClassName();

    /**
     * Returns the entity translation key.
     *
     * @return string
     */
    public static function getTranslationName();

    /**
     * Returns the create field view name.
     *
     * @return string
     */
    public static function getCreateFieldViewName();

    /**
     * Returns the translated create field view name.
     *
     * @return string
     */
    public static function getTranslatableCreateFieldViewName();


    /**
     * Returns the edit field view key.
     *
     * @return string
     */
    public static function getEditFieldViewName();

    /**
     * Returns the translated edit field view name.
     *
     * @return string
     */
    public static function getTranslatableEditFieldViewName();

}
