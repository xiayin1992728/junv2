<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->commnet('产品名称');
            $table->string('logo')->comment('产品logo');
            $table->decimal('maxs')->comment('最大额度');
            $table->string('tag')->comment('标签');
            $table->char('longtimes',20)->comment('借款期限');
            $table->string('link')->comment('产品链接');
            $table->string('saleman')->comment('产品业务员');
            $table->char('types',20)->default('外部产品')->comment('产品分类 内部产品 外部产品');
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
        Schema::dropIfExists('products');
    }
}
