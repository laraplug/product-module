<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/product'], function (Router $router) {
    $router->bind('product', function ($id) {
        return app('Modules\Product\Repositories\ProductRepository')->find($id);
    });
    $router->get('products', [
        'as' => 'admin.product.product.index',
        'uses' => 'ProductController@index',
        'middleware' => 'can:product.products.index'
    ]);
    $router->get('products/create', [
        'as' => 'admin.product.product.create',
        'uses' => 'ProductController@create',
        'middleware' => 'can:product.products.create'
    ]);
    $router->post('products', [
        'as' => 'admin.product.product.store',
        'uses' => 'ProductController@store',
        'middleware' => 'can:product.products.create'
    ]);
    $router->get('products/{product}/edit', [
        'as' => 'admin.product.product.edit',
        'uses' => 'ProductController@edit',
        'middleware' => 'can:product.products.edit'
    ]);
    $router->put('products/{product}', [
        'as' => 'admin.product.product.update',
        'uses' => 'ProductController@update',
        'middleware' => 'can:product.products.edit'
    ]);
    $router->delete('products/{product}', [
        'as' => 'admin.product.product.destroy',
        'uses' => 'ProductController@destroy',
        'middleware' => 'can:product.products.destroy'
    ]);
    $router->bind('category', function ($id) {
        return app('Modules\Product\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.product.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:product.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.product.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:product.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.product.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:product.categories.create'
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.product.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:product.categories.edit'
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.product.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:product.categories.edit'
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.product.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:product.categories.destroy'
    ]);
    $router->bind('basicproduct', function ($id) {
        return app('Modules\Product\Repositories\BasicProductRepository')->find($id);
    });
    $router->get('basicproducts', [
        'as' => 'admin.product.basicproduct.index',
        'uses' => 'BasicProductController@index',
        'middleware' => 'can:product.basicproducts.index'
    ]);
    $router->get('basicproducts/create', [
        'as' => 'admin.product.basicproduct.create',
        'uses' => 'BasicProductController@create',
        'middleware' => 'can:product.basicproducts.create'
    ]);
    $router->post('basicproducts', [
        'as' => 'admin.product.basicproduct.store',
        'uses' => 'BasicProductController@store',
        'middleware' => 'can:product.basicproducts.create'
    ]);
    $router->get('basicproducts/{basicproduct}/edit', [
        'as' => 'admin.product.basicproduct.edit',
        'uses' => 'BasicProductController@edit',
        'middleware' => 'can:product.basicproducts.edit'
    ]);
    $router->put('basicproducts/{basicproduct}', [
        'as' => 'admin.product.basicproduct.update',
        'uses' => 'BasicProductController@update',
        'middleware' => 'can:product.basicproducts.edit'
    ]);
    $router->delete('basicproducts/{basicproduct}', [
        'as' => 'admin.product.basicproduct.destroy',
        'uses' => 'BasicProductController@destroy',
        'middleware' => 'can:product.basicproducts.destroy'
    ]);
// append



});
