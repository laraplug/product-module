<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // product type
            $table->string('type');
            // product category
            $table->integer('category_id')->unsigned();
            // product info
            $table->string('sku')->nullable();
            // product price
            $table->integer('price')->unsigned();
            $table->integer('sale_price')->unsigned();
            $table->integer('min_order_limit');
            $table->integer('max_order_limit');
            // stock management
            $table->tinyInteger('use_stock');
            // tax
            $table->tinyInteger('use_tax');
            // etc
            $table->tinyInteger('use_review')->unsigned();
            // shipping
            $table->string('shipping_method_id')->nullable();
            $table->integer('shipping_storage_id')->unsigned();
            // status
            $table->enum('status',['active','hide','inactive'])->default('active');

            $table->timestamps();
        });

        Schema::create('product__product_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name');
            $table->text('content')->nullable();
            $table->text('description')->nullable();

            $table->integer('product_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['product_id', 'locale']);
            $table->foreign('product_id')->references('id')->on('product__products')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__product_translations');
        Schema::dropIfExists('product__products');
    }
}
