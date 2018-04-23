<?php

namespace Modules\Product\Entities\Products\Options;

use Modules\Product\Entities\Option;

/**
 * Input Month Type of ProductOption
 */
class InputMonth extends Option
{
    /**
     * @var string
     */
    protected static $entityNamespace = 'month';

    /**
     * @inheritDoc
     * @var string
     */
    protected $formFieldView = "product::admin.options.types.month";

    /**
     * @inheritDoc
     */
    public function getIsCollectionAttribute(): int
    {
        return false;
    }

}
