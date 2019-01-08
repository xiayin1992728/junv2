<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 先创建权限
        // 用户管理
        Permission::create(['name' => '用户管理','guard_name' => 'admin']);
        Permission::create(['name' => '前台用户','guard_name' => 'admin']);
        Permission::create(['name' => '后台用户','guard_name' => 'admin']);
        Permission::create(['name' => '添加用户','guard_name' => 'admin']);
        Permission::create(['name' => '修改用户','guard_name' => 'admin']);
        Permission::create(['name' => '删除用户','guard_name' => 'admin']);

        Permission::create(['name' => '权限管理','guard_name' => 'admin']);
        Permission::create(['name' => '角色列表','guard_name' => 'admin']);
        Permission::create(['name' => '添加角色','guard_name' => 'admin']);
        Permission::create(['name' => '修改角色','guard_name' => 'admin']);
        Permission::create(['name' => '删除角色','guard_name' => 'admin']);
        Permission::create(['name' => '权限列表','guard_name' => 'admin']);
        Permission::create(['name' => '修改权限','guard_name' => 'admin']);
        Permission::create(['name' => '添加权限','guard_name' => 'admin']);
        Permission::create(['name' => '删除权限','guard_name' => 'admin']);
       
        // 渠道管理
        Permission::create(['name' => '渠道管理','guard_name' => 'admin']);
        Permission::create(['name' => '添加渠道','guard_name' => 'admin']);
        Permission::create(['name' => '修改渠道','guard_name' => 'admin']);
        Permission::create(['name' => '删除渠道','guard_name' => 'admin']);

       
        // 产品管理
        Permission::create(['name' => '产品管理','guard_name' => 'admin']);
        Permission::create(['name' => '添加产品','guard_name' => 'admin']);
        Permission::create(['name' => '修改产品','guard_name' => 'admin']);
        Permission::create(['name' => '删除产品','guard_name' => 'admin']);
        Permission::create(['name' => '产品上下架','guard_name' => 'admin']);
        Permission::create(['name' => '页面添加','guard_name' => 'admin']);
        Permission::create(['name' => '页面修改','guard_name' => 'admin']);
        Permission::create(['name' => '页面删除','guard_name' => 'admin']);
        Permission::create(['name' => '页面管理','guard_name' => 'admin']);


        // 推广管理
        Permission::create(['name' => '推广管理','guard_name' => 'admin']);
        Permission::create(['name' => '添加推广','guard_name' => 'admin']);
        Permission::create(['name' => '修改推广','guard_name' => 'admin']);
        Permission::create(['name' => '删除推广','guard_name' => 'admin']);
        Permission::create(['name' => '推广统计','guard_name' => 'admin']);

        // 站点管理
        Permission::create(['name' => '链接开关','guard_name' => 'admin']);
        Permission::create(['name' => '站点管理','guard_name' => 'admin']);

        // 创建超级管理，并赋予权限
        $super = Role::create(['name' => '超级管理员','guard_name' => 'admin']);
        $super->givePermissionTo(Permission::all());


        // 创建管理员角色，并赋予权限
        $maintainer = Role::create(['name' => '管理员','guard_name' => 'admin']);
        $maintainer->givePermissionTo('渠道管理');
        $maintainer->givePermissionTo('推广统计');
        $maintainer->givePermissionTo('推广管理');
        $maintainer->givePermissionTo(['用户管理','前台用户','后台用户']);
        $maintainer->givePermissionTo('产品管理');
        
        // 创建推广角色
        $spread = Role::create(['name' => '推广员','guard_name' => 'admin']);
        $spread->givePermissionTo('推广统计');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 清空所有数据表数据
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
