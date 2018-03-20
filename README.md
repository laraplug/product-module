[![Latest Stable Version](https://poser.pugx.org/laraplug/product-module/v/stable.svg?format=flat-square)](https://github.com/laraplug/product-module/releases)
[![Software License](https://poser.pugx.org/laraplug/product-module/license.svg?format=flat-square)](LICENSE)
[![Daily Downloads](https://poser.pugx.org/laraplug/product-module/d/daily.svg?format=flat-square)](https://packagist.org/packages/laraplug/product-module)
[![Monthly Downloads](https://poser.pugx.org/laraplug/product-module/d/monthly.svg?format=flat-square)](https://packagist.org/packages/laraplug/product-module)
[![Total Downloads](https://poser.pugx.org/laraplug/product-module/d/total.svg?format=flat-square)](https://packagist.org/packages/laraplug/product-module)
[![PHP7 Compatible](https://img.shields.io/badge/php-7-green.svg?style=flat-square)](https://packagist.org/packages/laraplug/product-module)

# Laraplug Product

**Laraplug Product** is a flexible, extendable e-commerce module, built on top of [AsgardCMS](https://github.com/AsgardCms/Platform) platform.

Integrated with [laraplug/attribute-module](https://github.com/laraplug/attribute-module)

## Table Of Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Extend Product Model](#extend-product-model)
    - [Add EAV to Eloquent model](#add-eav-to-eloquent-model)
    - [Register Your Entities](#register-your-entities)
- [About Laraplug](#about-laraplug)
- [Contributing](#contributing)

## Installation

1. Install the package via composer:
    ```shell
    composer require laraplug/product-module
    ```

2. Execute migrations via [AsgardCMS](https://github.com/AsgardCms/Platform)'s module command:
    ```shell
    php artisan module:migrate Product
    ```

3. Execute publish via [AsgardCMS](https://github.com/AsgardCms/Platform)'s module command:
    ```shell
    php artisan module:publish Product
    ```

4. Done!


## Usage

### Extend Product Model

To create your own `Book` Product Eloquent model on `BookStore` module, just extend the `\Modules\Product\Entities\Product` model like this:

```php
use Modules\Product\Entities\Product;

class Book extends Product
{
    // Override entityNamespace to identify your Model on database
    protected static $entityNamespace = 'bookstore/book';

    // Override this method to convert Namespace into Human-Readable name
    public function getEntityName()
    {
        return trans('bookstore::books.title.books');
    }

}
```

### Add EAV to Eloquent model

Add `$systemAttributes` to utilize [laraplug/attribute-module](https://github.com/laraplug/attribute-module) on code-level like this:

```php
use Modules\Product\Entities\Product;

class Book extends Product
{
    ...

    // Set systemAttributes to define EAV attributes
    protected $systemAttributes = [
        'isbn' => [
            'type' => 'input'
        ],
        'media' => [
            'type' => 'checkbox',
            'options' => [
                'audio-cd',
                'audio-book',
                'e-book',
            ]
        ]
    ];
}
```

### Register Your Entities

You can register your Entity using `ProductManager` like this:

```php
use Modules\Product\Repositories\ProductManager;
use Modules\BookStore\Products\Book;

class BookStoreServiceProvider extends ServiceProvider
{
    ...

    public function boot()
    {
        ...

        // Register Book
        $this->app[ProductManager::class]->registerEntity(new Book());

        ...
    }
}
```

### About Laraplug

LaraPlug is a opensource project to build e-commerce solution on top of AsgardCMS.


## Contributing

We welcome any pull-requests or issues :)
