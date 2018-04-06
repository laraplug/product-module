<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributeProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__attribute_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->integer('attribute_id')->unsigned();

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product__products')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('product__attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__attributes');
    }
}
