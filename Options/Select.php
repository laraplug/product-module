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
     */
    public function getIsCollectionAttribute()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getFormField($elemAttributes = null)
    {
        $option = $this;
        return view("product::admin.options.types.select", compact('option', 'elemAttributes'));
    }

}
