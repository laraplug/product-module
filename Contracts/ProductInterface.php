<?php

namespace Modules\Product\Contracts;
use Modules\Attribute\Contracts\AttributesInterface;

/**
 * Interface for Productable
 */
interface ProductInterface extends AttributesInterface
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
