<?php

namespace Modules\Product\Entities\Products\Options;

use Modules\Product\Entities\Option;

/**
 * Input Year Type of ProductOption
 */
class InputYear extends Option
{
    /**
     * @var string
     */
    protected static $entityNamespace = 'year';

    /**
     * @inheritDoc
     * @var string
     */
    protected $formFieldView = "product::admin.options.types.year";

    /**
     * @inheritDoc
     */
    public function getIsCollectionAttribute(): int
    {
        return false;
    }

}
