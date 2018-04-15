<?php

namespace Modules\Product\Contracts;

use Modules\Shop\Contracts\ShopProductOptionInterface;

/**
 * Interface for Options
 */
interface OptionInterface extends ShopProductOptionInterface
{

    /**
     * The Eloquent attribute entity name.
     * @var string
     */
    public function getTypeAttribute();

    /**
     * Returns a human friendly name for the type.
     * @return string
     */
    public function getTypeNameAttribute();

}
