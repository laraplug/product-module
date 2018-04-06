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

}
