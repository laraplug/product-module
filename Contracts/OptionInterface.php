<?php

namespace Modules\Product\Contracts;

/**
 * Interface for Options
 */
interface OptionInterface
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
