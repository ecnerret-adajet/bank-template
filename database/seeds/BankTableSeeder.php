<?php

use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('banks')->insert([
            ['name' => 'Bank of the philippine island'],
            ['name' => 'Banco de oro'],
            ['name' => 'Security Bank'],
            ['name' => 'China Bank'],
            ['name' => 'East west bank'],
            ['name' => 'Philippine National Bank']
        ]);
    }
}
