<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBasicProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__basic_products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('length')->nullable();

            $table->timestamps();
        });

        Schema::create('product__basic_product_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('basic_product_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['basic_product_id', 'locale'], 'product__basic_product_id_locale');
            $table->foreign('basic_product_id')->references('id')->on('product__basic_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__basic_product_translations');
        Schema::dropIfExists('product__basic_products');
    }
}
