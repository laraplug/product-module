<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__options', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('option_group_id')->unsigned();
            $table->foreign('option_group_id')->references('id')->on('product__option_groups')->onDelete('cascade');

            $table->string('key');
            $table->string('sku')->nullable();
            $table->boolean('stock_enabled');
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_order_limit')->default(0);
            $table->integer('max_order_limit')->default(0);
            $table->enum('price_type', ['FIXED', 'PERCENTAGE'])->default('FIXED');
            $table->integer('price_value')->default(0);
            $table->mediumInteger('sort_order')->unsigned()->default(0);
            $table->boolean('enabled');

            $table->timestamps();

            $table->unique(['option_group_id', 'key']);
        });

        Schema::create('product__option_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('label');

            $table->integer('option_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['option_id', 'locale']);
            $table->foreign('option_id')->references('id')->on('product__options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__option_translations');
        Schema::dropIfExists('product__options');
    }
}
