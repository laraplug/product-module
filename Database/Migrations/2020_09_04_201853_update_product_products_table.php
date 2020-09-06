<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductProductsTable extends Migration
{
    /** 세금계산용 칼럼 추가 20200906Ho
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //면세인지 체크 칼럼 추가
        Schema::table('product__products', function (Blueprint $table) {
            //use_tax->is_tax_free > products 내부에 enum 칼럼이 추가되어 있어 rename이 안되서 drop 한 후 생성
            $table->dropColumn('use_tax');
            $table->integer('is_tax_free')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product__products', function (Blueprint $table) {
            $table->dropColumn('is_tax_free');
            $table->tinyInteger('use_tax');
        });

    }
}
