<?php

namespace Modules\Product\Repositories\Eloquent;

use Modules\Product\Events\ProductIsCreating;
use Modules\Product\Events\ProductIsUpdating;
use Modules\Product\Events\ProductWasCreated;
use Modules\Product\Events\ProductWasDeleted;
use Modules\Product\Events\ProductWasUpdated;
use Modules\Product\Repositories\ProductManager;
use Modules\Product\Repositories\ProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{

    /**
     * @inheritDoc
     */
    public function find($id)
    {
      $model = parent::find($id);
      return $model ? $model->load('attributes', 'optionGroups') : null;
    }

    /**
     * @inheritDoc
     */
    public function create($data)
    {
        event($event = new ProductIsCreating($data));

        // Override Product Instance
        $productManager = app(ProductManager::class);
        $type = array_get((array) $data, 'type');
        $this->model = $type ? $productManager->findByNamespace($type) : $this->model;

        $product = $this->model->create($event->getAttributes());

        event(new ProductWasCreated($product, $data));

        $product->setTags(array_get($data, 'tags', []));

        $product->setAttributes(array_get($data, 'attributes', []));

        $product->setOptionGroups(array_get($data, 'option_groups', []));

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

        $model->setTags(array_get($data, 'tags', []));

        $model->setAttributes(array_get($data, 'attributes', []));

        $model->setOptionGroups(array_get($data, 'option_groups', []));

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function destroy($model)
    {
        $model->untag();

        $model->removeAttributes();

        $model->removeOptionGroups();

        event(new ProductWasDeleted($model));

        return $model->delete();
    }

}
