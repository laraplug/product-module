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
            $table->string('currency_code')->nullable();
            $table->integer('regular_price')->default(0);
            $table->integer('sale_price')->default(0);
            // stock management
            $table->tinyInteger('use_stock')->default(0);
            $table->integer('stock_qty')->default(0);
            // tax
            $table->tinyInteger('use_tax')->default(0);
            // etc
            $table->tinyInteger('use_review')->default(0);
            $table->enum('status',['active','hide','inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('product__product_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            // product info
            $table->string('name');
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
