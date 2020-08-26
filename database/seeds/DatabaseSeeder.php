<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(WarehouseSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(LineSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
