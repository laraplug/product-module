<?php

namespace Modules\Product\Support;

use Modules\Product\Entities\Category as CategoryEntity;
use Modules\Product\Repositories\CategoryRepository;

class Category
{

    /**
     * @var CategoryRepository
     */
    private $category;

    /**
     * @param CategoryRepository $category
     */
    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Get category with ancestors as array
     * @param CategoryEntity $current
     * @return bool
     */
    public function getWithAncestors(CategoryEntity $current)
    {
        $categories = collect();
        do {
            $categories->prepend($current);
        } while($current = $current->parent);
        return $categories;
    }

    /**
     * Get model's slug with parents' slug as path
     * @param CategoryEntity $current
     * @return bool
     */
    public function getSlugPath(CategoryEntity $current)
    {
        return $this->getWithAncestors($current)->implode('slug', '/');
    }

    /**
     * Check if the current item is child of the slug
     * @param CategoryEntity $current
     * @param CategoryEntity $parent
     * @return bool
     */
    public function isDescendantOf(CategoryEntity $current, CategoryEntity $parent)
    {
        return (bool) $this->getWithAncestors($current)->where('slug', $parent->slug)->first();
    }

}
