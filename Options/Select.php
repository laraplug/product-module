<?php

namespace Modules\Product\Options;

use Modules\Product\Entities\Option;

/**
 * Select Type of ProductOption
 */
class Select extends Option
{
    /**
     * @var string
     */
    protected $entityNamespace = 'select';

    /**
     * @inheritDoc
     * @var string
     */
    protected $formFieldView = "product::admin.options.types.select";

    /**
     * @inheritDoc
     */
    public function getIsCollectionAttribute(): int
    {
        return true;
    }

}
