<?php

return [
    'product.products' => [
        'index' => 'product::products.list resource',
        'create' => 'product::products.create resource',
        'edit' => 'product::products.edit resource',
        'destroy' => 'product::products.destroy resource',
    ],
    'product.categories' => [
        'index' => 'product::categories.list resource',
        'create' => 'product::categories.create resource',
        'edit' => 'product::categories.edit resource',
        'destroy' => 'product::categories.destroy resource',
    ],
    'product.attributes' => [
        'index' => 'product::attributes.list resource',
        'create' => 'product::attributes.create resource',
        'edit' => 'product::attributes.edit resource',
        'destroy' => 'product::attributes.destroy resource',
    ],
// append





];
