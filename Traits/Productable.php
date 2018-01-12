<?php

namespace Modules\Product\Traits;

/**
 * Trait to support implementing Modules\Product\Contracts\ProductContract
 */
trait Productable
{

    /**
     * Returns the entity class name.
     *
     * @return string
     */
    public static function getClassName()
    {
        return static::class;
    }

    /**
     * Returns the entity translation key.
     *
     * @return void
     */
    public static function getTranslationName()
    {
        return isset(static::$translationName) ? static::$translationName : get_called_class();
    }

    /**
     * Returns the entity create field view name.
     *
     * @return void
     */
    public static function getCreateFieldViewName()
    {
        return isset(static::$createFieldViewName) ? static::$createFieldViewName : '';
    }

    /**
     * Returns the entity create field view name.
     *
     * @return void
     */
    public static function getTranslatableCreateFieldViewName()
    {
        return isset(static::$translatableCreateFieldViewName) ? static::$translatableCreateFieldViewName : '';
    }

    /**
     * Returns the entity edit field view key.
     *
     * @return void
     */
    public static function getEditFieldViewName()
    {
        return isset(static::$editFieldViewName) ? static::$editFieldViewName : '';
    }

    /**
     * Returns the entity edit field view key.
     *
     * @return void
     */
    public static function getTranslatableEditFieldViewName()
    {
        return isset(static::$translatableEditFieldViewName) ? static::$translatableEditFieldViewName : '';
    }
}
