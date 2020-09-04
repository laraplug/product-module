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
      return $model ? $model->load('attributes', 'options') : null;
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
        $model = $this->model->create($event->getAttributes());

        event(new ProductWasCreated($model, $data));

        $model->setTags(array_get($data, 'tags', []));

        $model->setAttributes(array_get($data, 'attributes', []));

        $this->saveShops($model, $data);

        return $model;
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

        $this->saveShops($model, $data);

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function destroy($model)
    {
        $model->untag();

        $model->removeAttributes();

        $model->removeOptions();

        $this->removeShops($model);

        event(new ProductWasDeleted($model));

        return $model->delete();
    }

    /**
     * @inheritDoc
     */
    protected function saveShops($product, $data)
    {
        return $product->shops()->sync($data['shops']);
    }

    /**
     * @inheritDoc
     */
    protected function removeShops($product)
    {
        return $product->shops()->detach();
    }

}
