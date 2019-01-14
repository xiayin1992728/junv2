<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
         $this->call(ProductPagesTableSeeder::class);
         //$this->call(SpreadTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
    }
}
