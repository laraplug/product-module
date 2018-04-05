<?php

namespace Modules\Product\Contracts;
use Modules\Attribute\Contracts\AttributableInterface;

/**
 * Interface for Productable
 */
interface ProductInterface extends AttributableInterface
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
