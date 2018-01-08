<?php

namespace Modules\Product\Services;

use Modules\Product\Entities\Category;
use Modules\Product\Repositories\CategoryRepository;

class CategoryOrdener
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param CategoryRepository $category
     */
    public function __construct(CategoryRepository $category)
    {
        $this->categoryRepository = $category;
    }

    /**
     * @param $data
     */
    public function handle($data)
    {
        $data = $this->convertToArray(json_decode($data));

        foreach ($data as $position => $item) {
            $this->order($position, $item);
        }
    }

    /**
     * Order recursively the categories
     * @param int   $position
     * @param array $item
     */
    private function order($position, $item)
    {
        $category = $this->categoryRepository->find($item['id']);
        $this->savePosition($category, $position);
        $this->makeItemChildOf($category, null);

        if ($this->hasChildren($item)) {
            $this->handleChildrenForParent($category, $item['children']);
        }
    }

    /**
     * @param Category $parent
     * @param array    $children
     */
    private function handleChildrenForParent(Category $parent, array $children)
    {
        foreach ($children as $position => $item) {
            $category = $this->categoryRepository->find($item['id']);
            $this->savePosition($category, $position);
            $this->makeItemChildOf($category, $parent->id);

            if ($this->hasChildren($item)) {
                $this->handleChildrenForParent($category, $item['children']);
            }
        }
    }

    /**
     * Save the given position on the category
     * @param object $category
     * @param int    $position
     */
    private function savePosition($category, $position)
    {
        $this->categoryRepository->update($category, compact('position'));
    }

    /**
     * Check if the item has children
     *
     * @param  array $item
     * @return bool
     */
    private function hasChildren($item)
    {
        return isset($item['children']);
    }

    /**
     * Set the given parent id on the given category
     *
     * @param object $item
     * @param int    $parent_id
     */
    private function makeItemChildOf($item, $parent_id)
    {
        $this->categoryRepository->update($item, compact('parent_id'));
    }

    /**
     * Convert the object to array
     * @param $data
     * @return array
     */
    private function convertToArray($data)
    {
        $data = json_decode(json_encode($data), true);

        return $data;
    }
}
