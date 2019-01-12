<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountPeoplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('count_peoples', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sid')->unsigned()->comment('推广外键');
            $table->integer('uid')->unsigned()->comment('推广人外键');
            $table->decimal('people',8,2)->comment('注册人数');
            $table->decimal('verify',8,2)->default(0)->comment('实名认证数');
            $table->decimal('moeny',8,2)->default(0)->comment('金额');
            $table->date('create_time')->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('count_peoples');
    }
}
