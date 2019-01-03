<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);

        $phones = [
        	'15108479103',
        	'18349227204',
        	'13402817879',
        	'15108479104',
        	'15108479105',
        	'15108479106',
        	'15108479107'
        ];

        // 生成数据集合
        $users = factory(User::class)
                        ->times(7)
                        ->make()
                        ->each(function ($user,$index) use ($phones) {
                        	$user->phone = $phones[$index];
                        	$user->password = bcrypt($phones[$index]);
                        });

         // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'xiayin';
        $user->phone = '15108479103';
        $user->save();
    }
}
