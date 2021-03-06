<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spreads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->unsigned()->comment('推广员外键');
            $table->integer('pid')->unsigned()->comment('产品外键');
            $table->string('number')->default(0)->comment('流水号');
            $table->char('change','15')->comment('链接开关');
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
        Schema::dropIfExists('spreads',function (Blueprint $table) {
            //$table->dropForeign('uid');
            //$table->dropForeign('pid');
        });
    }
}
