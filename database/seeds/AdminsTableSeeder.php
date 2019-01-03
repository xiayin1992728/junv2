<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$password = bcrypt('password');
    	$time = date('Y-m-d H:i:s',time());

        $datas = [
        	[
        		'phone' => '15108479103',
                'name' => '超级管理员',
        		'password'=>$password,
        		'created_at' => $time,
        		'updated_at' => $time
        	],
            [
                'phone' => '15108479104',
                'name' => '管理员',
                'password'=>$password,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'phone' => '15108479112',
                'name' => '推广1',
                'password'=>$password,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'phone' => '15108479111',
                'name' => '推广2',
                'password'=>$password,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];

        Admin::insert($datas);


        // 单独处理第一个用户的数据
        $admin = Admin::find(1);
        // 初始化用户角色，将 1 号用户指派为『站长』
        $admin->assignRole('超级管理员');

        // 将 2 号用户指派为『管理员』
        $admin = Admin::find(2);
        $admin->assignRole('管理员');

        // 指定为推广 
        $admin = Admin::find(3);
        $admin->assignRole('推广员');

        $admin = Admin::find(4);
        $admin->assignRole('推广员');
    }
}
