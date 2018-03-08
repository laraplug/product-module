<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__option_values', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('product__options')->onDelete('cascade');

            $table->integer('attribute_option_id')->unsigned();

            $table->string('key');
            $table->string('sku')->nullable();
            $table->boolean('stock_enabled');
            $table->integer('stock_quantity')->default(0);
            $table->enum('price_type', ['FIXED', 'PERCENTAGE'])->default('FIXED');
            $table->integer('price_value')->default(0);
            $table->mediumInteger('sort_order')->unsigned()->default(0);
            $table->boolean('enabled');

            $table->timestamps();

            $table->unique(['option_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__option_values');
    }
}
