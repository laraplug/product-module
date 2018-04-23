<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\CreateProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Product\Repositories\OptionManager;
use Modules\Product\Repositories\ProductManager;
use Modules\Product\Repositories\ProductRepository;
use Modules\Shop\Repositories\ShopRepository;

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
     * @var ProductManager
     */
    private $productManager;

    /**
     * @var OptionManager
     */
    private $optionManager;

    /**
     * @var CategoryRepository
     */
    private $category;

    /**
     * @var ShopRepository
     */
    private $shop;

    /**
     * Display a listing of the resource.
     *
     * @param ProductRepository $product
     * @param ProductManager $productManager
     * @param OptionManager $optionManager
     * @param CategoryRepository $category
     * @param ShopRepository $shop
     * @return Response
     */
    public function __construct(ProductRepository $product, ProductManager $productManager, OptionManager $optionManager, CategoryRepository $category, ShopRepository $shop)
    {
        parent::__construct();

        $this->product = $product;
        $this->productManager = $productManager;
        $this->optionManager = $optionManager;
        $this->category = $category;
        $this->shop = $shop;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $productTypes = $this->productManager->all();
        $products = $this->product->all();

        return view('product::admin.products.index', compact('products', 'productTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string  $type
     * @param Request $request
     * @return Response
     */
    public function create($type, Request $request)
    {
        if ($type && $product = $this->productManager->findByNamespace($type)) {
            $categories = $this->category->all()->nest()->listsFlattened('name');
            $shops = $this->shop->all();
            $optionTypes = $this->optionManager->all();

            return view('product::admin.products.create', compact('product', 'categories', 'shops', 'optionTypes'));
        }

        // If type is not exists, default type will be set
        $first = $this->productManager->first();

        return redirect()->route($request->route()->getName(), ['type' => $first->getEntityNamespace()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     * @return Response
     */
    public function store($type, CreateProductRequest $request)
    {
        $data = $request->all();
        $data['type'] = $type;
        $this->product->create($data);

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
        $categories = $this->category->all()->nest()->listsFlattened('name');

        $shops = $this->shop->all();

        $optionTypes = $this->optionManager->all();

        return view('product::admin.products.edit', compact('product', 'categories', 'shops', 'optionTypes'));
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
