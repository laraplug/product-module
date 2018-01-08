<?php

namespace Modules\Product\Database\Seeders;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SentinelGroupSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Save the permissions
        $group = Sentinel::findRoleBySlug('admin');

        $group->addPermission('product.products.index');
        $group->addPermission('product.products.create');
        $group->addPermission('product.products.edit');
        $group->addPermission('product.products.destroy');

        $group->addPermission('product.categories.index');
        $group->addPermission('product.categories.create');
        $group->addPermission('product.categories.edit');
        $group->addPermission('product.categories.destroy');

        $group->save();
    }
}
