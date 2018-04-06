<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__attribute_options', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->timestamps();
        });

        Schema::create('product__attribute_option_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('attribute_option_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['attribute_option_id', 'locale']);
            $table->foreign('attribute_option_id')->references('id')->on('product__attribute_options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__attribute_option_translations');
        Schema::dropIfExists('product__attribute_options');
    }
}
