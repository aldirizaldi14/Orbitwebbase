<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->delete();
        DB::table('user')->insert([
            'user_username' => 'admin',
            'user_password' => bcrypt('123456'),
            'user_group_id' => 1,
            'user_fullname' => 'Administrator',
            'api_token' => Str::random(60),
            'user_created_by' => 'Migrate',
        ]);
    }
}
