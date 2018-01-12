<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\CreateProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Product\Repositories\ProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Product\Repositories\ProductableManager;

/**
 * Controller for Product
 */
class ProductController extends AdminBaseController
{
    /**
     * @var ProductRepository
     */
    private $product;

    /**
     * @var ProductableManager
     */
    private $productable;

    /**
     * @var CategoryRepository
     */
    private $category;

    /**
     * Display a listing of the resource.
     *
     * @param ProductRepository $product
     * @param ProductableManager $productable
     * @param CategoryRepository $category
     * @return Response
     */
    public function __construct(ProductRepository $product, ProductableManager $productable, CategoryRepository $category)
    {
        parent::__construct();

        $this->product = $product;
        $this->productable = $productable;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = $this->product->all();
        $productables = $this->productable->all();

        return view('product::admin.products.index', compact('products', 'productables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $productables = $this->productable->all();
        $currentType = $request->query('type');

        // If type is invalid, default type will be set
        if(!$this->productable->findByClass($currentType)) {
            $first = $this->productable->first();
            return redirect()->route($request->route()->getName(), ['type' => $first->getClassName()]);
        }

        $categories = $this->category->getAllRoots();

        return view('product::admin.products.create', compact('productables', 'currentType', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $this->product->create($request->all());

        return redirect()->route('admin.product.product.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('product::products.title.products')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product $product
     * @return Response
     */
    public function edit(Product $product)
    {
        $categories = $this->category->getAllRoots();

        return view('product::admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product $product
     * @param  UpdateProductRequest $request
     * @return Response
     */
    public function update(Product $product, UpdateProductRequest $request)
    {
        $this->product->update($product, $request->all());

        return redirect()->route('admin.product.product.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('product::products.title.products')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        $this->product->destroy($product);

        return redirect()->route('admin.product.product.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('product::products.title.products')]));
    }
}
