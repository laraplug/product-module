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

    /**
     * {@inheritDoc}
     */
    public function getBySlugs(array $slugs)
    {
        $categories = collect();
        if(!isset($slugs[0])) return $categories;
        $rootCategory = $this->getAllRoots()->where('slug', $slugs[0])->first();
        if(!$rootCategory) return $categories;

        $categories->push($rootCategory);
        foreach ($slugs as $i => $slug) {
            $category = $categories->last()->children->where('slug', $slug)->first();
            if($category) $categories->push($category);
        }
        return $categories;
    }

}
