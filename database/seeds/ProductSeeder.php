<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->delete();
        DB::table('product')->insert([[
            'product_id' => 1,
            'product_code' => 'N01',
            'product_description' =>'Smart Light 1',
            'product_created_at' =>'2019-10-20 12:12',
            'product_created_by' =>'seeder',
        ],[
            'product_id' => 2,
            'product_code' => 'N02',
            'product_description' =>'Solar Lamp 1',
            'product_created_at' =>'2019-10-20 12:12',
            'product_created_by' =>'seeder',
        ],[
            'product_id' => 3,
            'product_code' => 'N03',
            'product_description' =>'PLC Lamp 1',
            'product_created_at' =>'2019-10-20 12:12',
            'product_created_by' =>'seeder',
        ]]);
    }
}
