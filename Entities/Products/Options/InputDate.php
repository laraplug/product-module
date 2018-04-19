<?php

namespace Modules\Product\Entities\Products\Options;

use Modules\Product\Entities\Option;

/**
 * Input Date Type of ProductOption
 */
class InputDate extends Option
{
    /**
     * @var string
     */
    protected $entityNamespace = 'date';

    /**
     * @inheritDoc
     * @var string
     */
    protected $formFieldView = "product::admin.options.types.date";

    /**
     * @inheritDoc
     */
    public function getIsCollectionAttribute(): int
    {
        return false;
    }

}
