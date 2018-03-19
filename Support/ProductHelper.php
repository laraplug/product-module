<?php

namespace Modules\Product\Support;

use Modules\Product\Entities\Category;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\CategoryRepository;

class ProductHelper
{
    /**
     * @var ProductRepository
     */
    private $product;

    /**
     * @var CategoryRepository
     */
    private $category;

    /**
     * @param ProductRepository $product
     * @param CategoryRepository $category
     */
    public function __construct(ProductRepository $product, CategoryRepository $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    /**
     * Get Default Currency for current locale
     * @return array
     */
    public function getDefaultCurrency()
    {
        $currency = currency(trans('product::products.currency.code'))->toArray();
        return $currency[trans('product::products.currency.code')];
    }

    /**
     * Get Lastest Products
     * @param  int $limit
     * @return mixed
     */
    public function getLatest($limit = 10)
    {
        return $this->product->paginate($limit);
    }

    /**
     * Get Lastest Products
     * @param  int $categoryId
     * @param  int $limit
     * @return mixed
     */
    public function getByCategory($categoryId, $limit = 10)
    {
        $category = $this->category->find($categoryId);
        if(!$category) return collect();
        $categoryIds = collect($this->getChildrenCategories($category))->pluck('id');
        return $this->product->allWithBuilder()->whereIn('category_id', $categoryIds)->paginate($limit);
    }

    protected function getChildrenCategories(Category $category, $results = [])
    {
        $results[] = $category;
        foreach ($category->children as $child) {
            $results = $this->getChildrenCategories($child, $results);
        }
        return $results;
    }

}
