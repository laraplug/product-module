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
    $router->get('products/create/{type}', [
        'as' => 'admin.product.product.create',
        'uses' => 'ProductController@create',
        'middleware' => 'can:product.products.create'
    ]);
    $router->post('products/{type}', [
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
    $router->bind('storage', function ($id) {
        return app('Modules\Product\Repositories\StorageRepository')->find($id);
    });
    $router->get('storages', [
        'as' => 'admin.product.storage.index',
        'uses' => 'StorageController@index',
        'middleware' => 'can:product.storages.index'
    ]);
    $router->get('storages/create', [
        'as' => 'admin.product.storage.create',
        'uses' => 'StorageController@create',
        'middleware' => 'can:product.storages.create'
    ]);
    $router->post('storages', [
        'as' => 'admin.product.storage.store',
        'uses' => 'StorageController@store',
        'middleware' => 'can:product.storages.create'
    ]);
    $router->get('storages/{storage}/edit', [
        'as' => 'admin.product.storage.edit',
        'uses' => 'StorageController@edit',
        'middleware' => 'can:product.storages.edit'
    ]);
    $router->put('storages/{storage}', [
        'as' => 'admin.product.storage.update',
        'uses' => 'StorageController@update',
        'middleware' => 'can:product.storages.edit'
    ]);
    $router->delete('storages/{storage}', [
        'as' => 'admin.product.storage.destroy',
        'uses' => 'StorageController@destroy',
        'middleware' => 'can:product.storages.destroy'
    ]);
// append






});
