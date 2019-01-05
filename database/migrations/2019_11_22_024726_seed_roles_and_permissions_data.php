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
        Permission::create(['name' => '角色','guard_name' => 'admin']);
        Permission::create(['name' => '权限','guard_name' => 'admin']);
       
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

        $super->givePermissionTo(['用户管理','角色','权限','添加用户','修改用户','删除用户','前台用户','后台用户']);

        $super->givePermissionTo(['站点管理','链接开关']);

        $super->givePermissionTo(['渠道管理','添加渠道','修改渠道','删除渠道']);

        $super->givePermissionTo(['产品管理','添加产品','修改产品','删除产品']);
        $super->givePermissionTo(['页面管理','页面添加','页面修改','页面删除']);

        $super->givePermissionTo(['推广管理','推广统计','修改推广','添加推广','删除推广']);



        // 创建管理员角色，并赋予权限
        $maintainer = Role::create(['name' => '管理员','guard_name' => 'admin']);
        $maintainer->givePermissionTo('渠道管理');
        $maintainer->givePermissionTo('推广统计');
        $maintainer->givePermissionTo('推广管理');
        $maintainer->givePermissionTo('角色');
        $maintainer->givePermissionTo('权限');
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
