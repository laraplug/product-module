<?php

namespace Modules\Product\Entities\Products\Options;

use Modules\Product\Entities\Option;

/**
 * Input Text Type of ProductOption
 */
class InputText extends Option
{
    /**
     * @var string
     */
    protected static $entityNamespace = 'text';

    /**
     * @inheritDoc
     * @var string
     */
    protected $formFieldView = "product::admin.options.types.text";

    /**
     * @inheritDoc
     */
    public function getIsCollectionAttribute(): int
    {
        return false;
    }

}
