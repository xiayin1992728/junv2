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


        // 生成数据集合
        $users = factory(User::class)
                        ->times(100)
                        ->make();


         // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'xiayin';
        $user->phone = '15108479103';
        $user->save();
    }
}
