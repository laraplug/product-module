<?php

namespace Modules\Product\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Contracts\ProductableInterface;
use Modules\Product\Traits\Productable;

/**
 * Basic Type of Product
 */
class BasicProduct extends Model implements ProductableInterface
{
    use Translatable, Productable;

    protected $table = 'product__basic_products';
    protected $fillable = [
        'weight',
        'height',
        'width',
        'length',
    ];

    /**
     * Translated attributes array
     *
     * @var array
     */
    public $translatedAttributes = [

    ];

    /**
     * Translation name for function trans()
     *
     * @var string
     */
    protected static $translationName = 'product::products.types.basic';

    /**
     * View name for create field
     *
     * @var string
     */
    protected static $createFieldViewName = 'product::admin.basicproducts.partials.create-fields';

    /**
     * View name for translatable create field
     *
     * @var string
     */
    protected static $translatableCreateFieldViewName = '';

    /**
     * View name for edit field
     *
     * @var string
     */
    protected static $editFieldViewName = 'product::admin.basicproducts.partials.edit-fields';

    /**
     * View name for translatable edit field
     *
     * @var string
     */
    protected static $translatableEditFieldViewName = '';

}
