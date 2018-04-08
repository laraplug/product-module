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

            $table->integer('product_id')->unsigned();
            $table->string('slug', 50);

            $table->string('type', 50);
            $table->mediumInteger('sort_order')->unsigned();
            $table->boolean('required');

            $table->timestamps();

            $table->index(['product_id', 'slug']);
        });

        Schema::create('product__option_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name');

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
