<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Product\Services\CategoryOrdener;

/**
 * @resource ProductCategory
 */
class CategoryController extends Controller
{
    /**
     * @var Repository
     */
    private $cache;
    /**
     * @var CategoryOrdener
     */
    private $categoryOrdener;
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(CategoryOrdener $categoryOrdener, Repository $cache, CategoryRepository $category)
    {
        $this->cache = $cache;
        $this->categoryOrdener = $categoryOrdener;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     */
    public function index(Request $request)
    {
        $categories = $this->category->all();

        return Response::json(['errors' => false, 'data' => $categories]);
    }

    /**
     * Update all categories
     * @param Request $request
     */
    public function update(Request $request)
    {
        $this->cache->tags('categories')->flush();

        $this->categoryOrdener->handle($request->get('categories'));
    }

    /**
     * Delete a category
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $category = $this->category->find($request->get('category'));

        if (!$category) {
            return Response::json(['errors' => true]);
        }

        $this->category->destroy($category);

        return Response::json(['errors' => false]);
    }
}
