<?php

namespace Modules\Product\Repositories\Eloquent;

use Modules\Product\Events\ProductIsCreating;
use Modules\Product\Events\ProductIsUpdating;
use Modules\Product\Events\ProductWasCreated;
use Modules\Product\Events\ProductWasDeleted;
use Modules\Product\Events\ProductWasUpdated;
use Modules\Product\Repositories\ProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{
    /**
     * @inheritDoc
     */
    public function create($data)
    {
        event($event = new ProductIsCreating($data));

        $product = $this->model->create($event->getAttributes());

        event(new ProductWasCreated($product, $data));

        return $product;
    }

    /**
     * @inheritDoc
     */
    public function update($model, $data)
    {
        event($event = new ProductIsUpdating($model, $data));

        $model->update($event->getAttributes());

        event(new ProductWasUpdated($model, $data));

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function destroy($model)
    {
        event(new ProductWasDeleted($model));

        return $model->delete();
    }

}
