<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBundleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__bundle_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('bundle_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->integer('quantity')->unsigned();
            $table->json('option_values');

            $table->timestamps();

            $table->foreign('bundle_id')->references('id')->on('product__products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__bundle_items');
    }
}
