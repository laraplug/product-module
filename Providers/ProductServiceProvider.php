<?php

namespace Modules\Product\Providers;

use Illuminate\Support\ServiceProvider;

use Modules\Media\Image\ThumbnailManager;

use Modules\Product\Support\Product;
use Modules\Product\Support\Category;

use Modules\Attribute\Repositories\AttributesManager;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Product\Events\Handlers\RegisterProductSidebar;
use Modules\Product\Products\BasicProduct;
use Modules\Product\Repositories\ProductManager;
use Modules\Product\Repositories\ProductManagerRepository;

/**
 * Service Provider for Product
 */
class ProductServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterProductSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('products', array_dot(trans('product::products')));
            $event->load('categories', array_dot(trans('product::categories')));
            $event->load('basicproducts', array_dot(trans('product::basicproducts')));
            $event->load('options', array_dot(trans('product::options')));
            // append translations





        });

    }

    public function boot()
    {
        $this->publishConfig('product', 'permissions');

        // Register BasicProduct to Product
        $this->app[ProductManager::class]->registerEntity(new BasicProduct());

        $this->registerThumbnails();

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->singleton('shop.product', function ($app) {
            return new Product($app['Modules\Product\Repositories\ProductRepository'], $app['Modules\Product\Repositories\CategoryRepository']);
        });
        $this->app->singleton('shop.category', function ($app) {
            return new Category($app['Modules\Product\Repositories\CategoryRepository']);
        });
        $this->app->bind(
            'Modules\Product\Repositories\ProductRepository',
            function () {
                $repository = new \Modules\Product\Repositories\Eloquent\EloquentProductRepository(new \Modules\Product\Entities\Product());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Product\Repositories\Cache\CacheProductDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Product\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Product\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Product\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Product\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Product\Repositories\OptionRepository',
            function () {
                $repository = new \Modules\Product\Repositories\Eloquent\EloquentOptionRepository(new \Modules\Product\Entities\Option());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Product\Repositories\Cache\CacheOptionDecorator($repository);
            }
        );
// add bindings



        $this->app->singleton(ProductManager::class, function () {
            return new ProductManagerRepository();
        });
    }

    private function registerThumbnails()
    {
        $this->app[ThumbnailManager::class]->registerThumbnail('largeThumb', [
            'resize' => [
                'width' => 500,
                'height' => null,
                'callback' => function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                },
            ],
        ]);
    }
}
