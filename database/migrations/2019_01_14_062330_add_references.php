<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spreads',function (Blueprint $table) {
            $table->foreign('uid')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('pid')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('count_peoples',function (Blueprint $table) {
           $table->foreign('uid')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('sid')->references('id')->on('spreads')->onDelete('cascade');
        });

        Schema::table('product_pages',function (Blueprint $table) {
            $table->foreign('pid')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('users',function (Blueprint $table) {
            $table->foreign('sid')->references('id')->on('spreads')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spreads', function (Blueprint $table) {
            // 移除外键约束
            $table->dropForeign(['uid']);
        });

        Schema::table('product_pages', function (Blueprint $table) {
            $table->dropForeign(['pid']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sid']);
        });

        Schema::table('count_peoples', function (Blueprint $table) {
            $table->dropForeign(['uid']);
            $table->dropForeign(['sid']);
        });
    }
}
