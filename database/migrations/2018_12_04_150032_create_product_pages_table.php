<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->unsigned()->comment('产品外键');
            $table->string('name')->comment('页面名称');
            $table->string('pages')->comment('页面');
            $table->timestamps();
            $table->foreign('pid')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('count_peoples', function (Blueprint $table) {
            $table->dropForeign(['pid']);
        });
        Schema::dropIfExists('product_pages');
    }
}
