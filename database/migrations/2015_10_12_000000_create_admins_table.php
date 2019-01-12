<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->char('phone',15)->index()->comment('手机号');
            $table->string('name')->comment('名称');
            $table->string('password',60)->comment('密码');
            $table->string('alias',60)->default(0)->comment('公司简称');
            $table->string('company',80)->default(0)->comment('公司名称');
            $table->string('types',80)->default(0)->comment('结算方式');
            $table->rememberToken()->comment('记住我');
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
        Schema::dropIfExists('admins');
    }
}
