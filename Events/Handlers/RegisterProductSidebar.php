<?php

namespace Modules\Product\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

/**
 * Register Item to Sidebar
 */
class RegisterProductSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param  BuildingSidebar $sidebar
     * @return void
     */
    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(config('asgard.product.config.sidebar-group'), function (Group $group) {
            $group->item(trans('product::products.list resource'), function (Item $item) {
                $item->icon('fa fa-cube');
                $item->weight(10);
                $item->route('admin.product.product.index');
                $item->authorize(
                    $this->auth->hasAccess('product.products.index')
                );
            });
            $group->item(trans('product::products.title.manage product'), function (Item $group) {
                $group->weight(10);
                $group->item(trans('product::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-sitemap');
                    $item->weight(10);
                    //$item->append('admin.product.category.create');
                    $item->route('admin.product.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('product.categories.index')
                    );
                });
                $group->item(trans('product::storages.title.storages'), function (Item $item) {
                    $item->icon('fa fa-archive');
                    $item->weight(0);
                    $item->route('admin.product.storage.index');
                    $item->authorize(
                        $this->auth->hasAccess('product.storages.index')
                    );
                });
            });

// append




        });

        return $menu;
    }
}
