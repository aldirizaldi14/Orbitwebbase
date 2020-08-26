<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('area')->delete();
        DB::table('area')->insert([[
            'area_id' => 1,
            'area_name' => 'A1',
            'area_description' =>'-',
            'area_warehouse_id' =>'1',
            'area_created_at' =>'2019-10-20 12:12',
            'area_created_by' =>'seeder',
        ],[
            'area_id' => 2,
            'area_name' => 'A2',
            'area_description' =>'-',
            'area_warehouse_id' =>'1',
            'area_created_at' =>'2019-10-20 12:12',
            'area_created_by' =>'seeder',
        ],[
            'area_id' => 3,
            'area_name' => 'B1',
            'area_description' =>'-',
            'area_warehouse_id' =>'1',
            'area_created_at' =>'2019-10-20 12:12',
            'area_created_by' =>'seeder',
        ],[
            'area_id' => 4,
            'area_name' => 'B2',
            'area_description' =>'-',
            'area_warehouse_id' =>'1',
            'area_created_at' =>'2019-10-20 12:12',
            'area_created_by' =>'seeder',
        ]]);
    }
}
