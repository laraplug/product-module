<?php

namespace Modules\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Product\Contracts\StoringProduct;
use Modules\Product\Entities\BasicProduct;
use Modules\Product\Events\Handlers\RegisterProductSidebar;
use Modules\Product\Events\Handlers\HandleProductableEntity;
use Modules\Product\Repositories\ProductableManager;
use Modules\Product\Repositories\ProductableManagerRepository;

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
            // append translations



        });

        // Event handler for registering productable type
        $this->app['events']->listen(
            StoringProduct::class,
            HandleProductableEntity::class
        );

    }

    public function boot()
    {
        $this->publishConfig('product', 'permissions');

        // Register BasicProduct
        $this->app[ProductableManager::class]->register(new BasicProduct());

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
// add bindings

        $this->app->singleton(ProductableManager::class, function () {
            return new ProductableManagerRepository();
        });
    }
}
