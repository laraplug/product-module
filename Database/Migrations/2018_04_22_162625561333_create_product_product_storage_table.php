<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProductStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__product_storage', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->integer('storage_id')->unsigned();
            $table->integer('quantity')->unsigned();

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product__products')->onDelete('cascade');
            $table->foreign('storage_id')->references('id')->on('product__storages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__product_storage');
    }
}
