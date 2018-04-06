<?php

namespace Modules\Attribute\Blade\Facades;

use Illuminate\Support\Facades\Facade;

final class AttributesDirective extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'attribute.attributes.directive';
    }
}
