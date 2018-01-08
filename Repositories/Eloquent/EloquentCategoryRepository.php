<?php

namespace Modules\Product\Repositories\Eloquent;

use Modules\Product\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{

    /**
     * Get all root elements
     *
     * @param  int    $categoryId
     * @return object
     */
    public function getAllRoots()
    {
        return $this->model->with('translations')->orderBy('parent_id')->orderBy('position')->get();
    }

}
