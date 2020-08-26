<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('line')->delete();
        DB::table('line')->insert([[
            'line_id' => 1,
            'line_name' => 'Downlight',
            'line_description' =>'-',
            'line_created_at' =>'2019-10-20 12:12',
            'line_created_by' =>'seeder',
        ],[
            'line_id' => 2,
            'line_name' => 'Aquarium',
            'line_description' =>'-',
            'line_created_at' =>'2019-10-20 12:12',
            'line_created_by' =>'seeder',
        ],[
            'line_id' => 3,
            'line_name' => 'Smart Light',
            'line_description' =>'-',
            'line_created_at' =>'2019-10-20 12:12',
            'line_created_by' =>'seeder',
        ]]);
    }
}
