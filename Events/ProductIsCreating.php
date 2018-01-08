<?php

namespace Modules\Product\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;

class ProductIsCreating extends AbstractEntityHook implements EntityIsChanging
{
}
