<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Artisan',
            'email' => 'x@lafilgroup.com',
            'password' => bcrypt('password')
        ]);
    }
}
