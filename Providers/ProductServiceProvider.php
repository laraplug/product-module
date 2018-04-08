<?php

namespace Modules\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Media\Image\ThumbnailManager;
use Modules\Product\Options\Select;
use Modules\Product\Options\InputText;
use Modules\Product\Repositories\OptionManager;
use Modules\Product\Repositories\OptionManagerRepository;
use Modules\Product\Events\Handlers\RegisterProductSidebar;
use Modules\Product\Products\BasicProduct;
use Modules\Product\Repositories\ProductManager;
use Modules\Product\Repositories\ProductManagerRepository;
use Modules\Product\Support\CategoryHelper;
use Modules\Product\Support\ProductHelper;

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
        $this->publishConfig('product', 'config');
        $this->publishConfig('product', 'permissions');

        // Register BasicProduct to Product
        $this->app[ProductManager::class]->registerEntity(new BasicProduct());
        // Register InputText to Option
        $this->app[OptionManager::class]->registerEntity(new InputText());
        $this->app[OptionManager::class]->registerEntity(new Select());

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
        $this->app->singleton(ProductManager::class, function () {
            return new ProductManagerRepository();
        });
        $this->app->singleton(OptionManager::class, function () {
            return new OptionManagerRepository();
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
            'Modules\Product\Repositories\OptionGroupRepository',
            function () {
                $repository = new \Modules\Product\Repositories\Eloquent\EloquentOptionGroupRepository(new \Modules\Product\Entities\OptionGroup());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Product\Repositories\Cache\CacheOptionGroupDecorator($repository);
            }
        );
        // add bindings


    }


}
