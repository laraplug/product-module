<?php

namespace Modules\Product\Attributes;

use Modules\Product\Entities\Attribute;

final class Select extends Attribute
{
    /**
     * 타입
     * Type Namespace
     * @var string
     */
    public static $entityNamespace = 'select';

    /**
     * @inheritDoc
     */
    public function useOptions()
    {
        return true;
    }

}
