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

            $table->timestamps();
        });

        Schema::create('product__bundle_item_options', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('bundle_item_id')->unsigned();
            $table->integer('product_option_id')->unsigned();
            $table->text('value');

            $table->timestamps();

            $table->foreign('bundle_item_id')->references('id')->on('product__bundle_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__bundle_item_options');
        Schema::dropIfExists('product__bundle_items');
    }
}
