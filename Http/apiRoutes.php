<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/product', 'middleware' => ['bindings', 'api.token', 'auth.admin']], function (Router $router) {
    $router->get('products', [
        'as' => 'api.product.products.index',
        'uses' => 'ProductController@index',
        'middleware' => 'token-can:product.products.index',
    ]);
    $router->get('products-server-side', [
        'as' => 'api.product.products.indexServerSide',
        'uses' => 'ProductController@indexServerSide',
        'middleware' => 'token-can:product.products.index',
    ]);
    $router->delete('products/{product}', [
        'as' => 'api.product.products.destroy',
        'uses' => 'ProductController@destroy',
        'middleware' => 'token-can:product.products.destroy',
    ]);
    $router->post('products', [
        'as' => 'api.product.products.store',
        'uses' => 'ProductController@store',
        'middleware' => 'token-can:product.products.create',
    ]);
    $router->post('products/{product}', [
        'as' => 'api.product.products.find',
        'uses' => 'ProductController@find',
        'middleware' => 'token-can:product.products.edit',
    ]);
    $router->post('products/{product}/edit', [
        'as' => 'api.product.products.update',
        'uses' => 'ProductController@update',
        'middleware' => 'token-can:product.products.edit',
    ]);

    $router->group(['prefix' => 'categories'], function (Router $router) {
        $router->get('/', [
            'as' => 'api.product.category.index',
            'uses' => 'CategoryController@index',
            'middleware' => 'token-can:product.categories.index',
        ]);

        $router->post('/update', [
            'as' => 'api.product.category.update',
            'uses' => 'CategoryController@update',
            'middleware' => 'token-can:product.categories.edit',
        ]);
        $router->post('/delete', [
            'as' => 'api.product.category.delete',
            'uses' => 'CategoryController@delete',
            'middleware' => 'token-can:product.categories.destroy',
        ]);
    });
});
