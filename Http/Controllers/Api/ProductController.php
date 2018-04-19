<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\CreateProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;

/**
 * @resource Product
 */
class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function indexServerSide(Request $request)
    {
        $products = Product::query();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $products->whereHas('translations', function ($query) use ($term) {
                $query->where('name', 'LIKE', "%{$term}%");
                $query->orWhere('sku', 'LIKE', "%{$term}%");
            })
            ->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            if (str_contains($request->get('order_by'), '.')) {
                $fields = explode('.', $request->get('order_by'));

                $products->with('translations')->join('product__product_translations as t', function ($join) {
                    $join->on('product__products.id', '=', 't.product_id');
                })
                ->where('t.locale', locale())
                ->groupBy('product__products.id')->orderBy("t.{$fields[1]}", $order);
            } else {
                $products->orderBy($request->get('order_by'), $order);
            }
        }

        return $products->paginate($request->get('per_page', 10));
    }

    public function store(CreateProductRequest $request)
    {
        $this->product->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('product::products.messages.product created'),
        ]);
    }

    public function find(Product $product)
    {
        $productData = $product->toArray();

        foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
            $productData[$locale] = [];
            foreach ($product->translatedAttributes as $translatedAttribute) {
                $productData[$locale][$translatedAttribute] = $product->translateOrNew($locale)->$translatedAttribute;
            }
        }

        foreach ($product->tags as $tag) {
            $productData['tags'][] = $tag->name;
        }

        return response()->json([
            'errors' => false,
            'data' => $productData,
        ]);
    }

    public function update(Product $product, UpdateProductRequest $request)
    {
        $this->product->update($product, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('product::products.messages.product updated'),
        ]);
    }

    public function destroy(Product $product)
    {
        $this->product->destroy($product);

        return response()->json([
            'errors' => false,
            'message' => trans('product::products.messages.product deleted'),
        ]);
    }
}
