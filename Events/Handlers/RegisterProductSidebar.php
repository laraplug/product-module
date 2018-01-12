<?php

namespace Modules\Product\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

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
        $menu->group(trans('product::products.ecommerce'), function (Group $group) {
            $group->weight(10);
            $group->item(trans('product::products.title.products'), function (Item $item) {
                $item->icon('fa fa-cubes');
                $item->weight(10);
                $item->authorize(
                  $this->auth->hasAccess('product.products.index')
                );

                $item->item(trans('product::products.list resource'), function (Item $item) {
                    $item->icon('fa fa-cubes');
                    $item->weight(0);
                    $item->route('admin.product.product.index');
                    $item->authorize(
                        $this->auth->hasAccess('product.products.index')
                    );
                });
                $item->item(trans('product::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    //$item->append('admin.product.category.create');
                    $item->route('admin.product.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('product.categories.index')
                    );
                });
                $item->item(trans('product::basicproducts.title.basicproducts'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.product.basicproduct.create');
                    $item->route('admin.product.basicproduct.index');
                    $item->authorize(
                        $this->auth->hasAccess('product.basicproducts.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
