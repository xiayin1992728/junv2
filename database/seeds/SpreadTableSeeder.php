<?php

use Illuminate\Database\Seeder;
use App\Models\Spread;

class SpreadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spreads = factory(Spread::class)->times(20)->make();
        Spread::insert($spreads->toArray());
    }
}
