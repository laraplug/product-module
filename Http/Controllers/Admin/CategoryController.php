<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Entities\Category;
use Modules\Product\Http\Requests\CreateCategoryRequest;
use Modules\Product\Http\Requests\UpdateCategoryRequest;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Product\Services\CategoryRenderer;

class CategoryController extends AdminBaseController
{
    /**
     * @var CategoryRepository
     */
    private $category;
    /**
     * @var CategoryRenderer
     */
    private $categoryRenderer;

    public function __construct(CategoryRepository $category, CategoryRenderer $categoryRenderer)
    {
        parent::__construct();

        $this->category = $category;
        $this->categoryRenderer = $categoryRenderer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->category->getAllRoots();

        $categoryStructure = $this->categoryRenderer->render($categories->nest());

        return view('product::admin.categories.index', compact('categories', 'categoryStructure'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->category->getAllRoots();

        return view('product::admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest $request
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->category->create($request->all());

        return redirect()->route('admin.product.category.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('product::categories.title.categories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        $categories = $this->category->getAllRoots();

        return view('product::admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Category $category
     * @param  UpdateCategoryRequest $request
     * @return Response
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $this->category->update($category, $request->all());

        return redirect()->route('admin.product.category.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('product::categories.title.categories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        $this->category->destroy($category);

        return redirect()->route('admin.product.category.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('product::categories.title.categories')]));
    }
}
