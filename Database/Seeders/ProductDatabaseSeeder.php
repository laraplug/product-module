<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Entities\Category;

use Illuminate\Database\Eloquent\Model;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $category = new Category([
            'slug' => 'book',
            'name' => 'Book',
        ]);
        $category->save();

        $this->call(SentinelGroupSeedTableSeeder::class);
    }
}
