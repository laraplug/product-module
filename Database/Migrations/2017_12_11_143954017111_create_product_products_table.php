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
            // product info
            $table->enum('type',['BASIC','VARIATION','VIRTUAL','DOWNLOADABLE'])->default('BASIC');
            $table->string('name');
            $table->string('sku')->nullable();
            $table->text('description')->nullable();
            $table->string('weight')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            // product price
            $table->integer('price');
            $table->integer('regular_price');
            $table->integer('sale_price');
            // stock management
            $table->tinyInteger('manage_stock')->default(0);
            $table->integer('stock_qty');
            // tax
            $table->tinyInteger('is_taxable')->default(0);
            // etc
            $table->tinyInteger('reviews_allowed')->default(0);
            $table->enum('status',['PENDING','ACTIVE','INACTIVE'])->default('PENDING');
            $table->timestamps();
        });

        Schema::create('product__product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('path');
            $table->tinyInteger('is_featured')->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('product__product_images');
        Schema::dropIfExists('product__products');
    }
}
