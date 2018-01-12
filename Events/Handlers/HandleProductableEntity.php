<?php

namespace Modules\Product\Events\Handlers;
use Modules\Product\Contracts\StoringProduct;
use Modules\Product\Entities\BasicProduct;

/**
 * Handles productable entities
 */
class HandleProductableEntity
{

    /**
     * Event Handler
     * @param  StoringProduct $event
     * @return void
     */
    public function handle(StoringProduct $event)
    {
        // If created type is matched, store it
        if ($event->getProductableType() == BasicProduct::class) {
            $this->handleProduct($event);
        }
    }

    /**
     * Handle the request to parse productable entitiy
     * @param StoringProduct $event
     */
    private function handleProduct(StoringProduct $event)
    {
        $entity = $event->getEntity();

        $postData = array_get($event->getSubmissionData(), 'productable', []);

        if(isset($postData['id'])) {
            $productable = BasicProduct::find($postData['id']);
            $productable->fill($postData);
        } else {
            $productable = new BasicProduct($postData);
        }
        $productable->save();

        $entity->productable_id = $productable->id;
        $entity->save();
    }

}
