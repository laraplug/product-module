<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__attributes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('code', 50);

            $table->string('type', 50);
            $table->boolean('is_enabled');
            $table->boolean('is_system');
            $table->boolean('is_required');
            $table->boolean('is_translatable');

            $table->timestamps();
        });

        Schema::create('product__attribute_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name');

            $table->integer('attribute_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['attribute_id', 'locale']);
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
        Schema::dropIfExists('product__attribute_translations');
        Schema::dropIfExists('product__attributes');
    }
}
