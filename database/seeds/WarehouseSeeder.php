<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouse')->delete();
        DB::table('warehouse')->insert([[
            'warehouse_id' => 1,
            'warehouse_name' => 'Production Store',
            'warehouse_description' =>'Temporary warehouse to store production output',
            'warehouse_created_at' =>'2019-10-20 12:12',
        ],[
            'warehouse_id' => 2,
            'warehouse_name' => 'Finish Good',
            'warehouse_description' =>'Warehouse to store finish good after allocation',
            'warehouse_created_at' =>'2019-10-20 12:12',
        ]]);
    }
}
