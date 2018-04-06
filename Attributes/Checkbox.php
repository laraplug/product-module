<?php

namespace Modules\Product\Attributes;

use Modules\Product\Entities\Attribute;

final class Checkbox extends Attribute
{

    /**
     * 타입
     * Type Namespace
     * @var string
     */
    public static $entityNamespace = 'checkbox';

    /**
     * @inheritDoc
     */
    public function hasOptions()
    {
        return true;
    }


}
