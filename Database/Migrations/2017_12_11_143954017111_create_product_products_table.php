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
            $table->enum('type',['BASIC','VIRTUAL','DOWNLOADABLE','PRINTABLE'])->default('BASIC');
            $table->string('name', 255);
            $table->string('sku');
            $table->text('description');
            $table->integer('price');
            $table->enum('status',['PENDING','ACTIVE','INACTIVE'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__products');
    }
}
