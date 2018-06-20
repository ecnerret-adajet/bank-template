<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            ['name' => 'Philippine Foremost Milling Corporation'],
            ['name' => 'Lafilipina Uy Gongoco Corporation'],
            ['name' => 'Amigo Logistics Corpotation'],
            ['name' => 'Philippine Leading Infinite Logistics Corp'],
            ['name' => 'Capiz Sugar Central Inc']
        ]);
    }
}
