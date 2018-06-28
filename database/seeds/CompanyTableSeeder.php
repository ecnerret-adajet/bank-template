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
            [
                'name' => 'Philippine Foremost Milling Corporation',
                'abbrv' => 'PFMCFL',
                'department' => 'Flour'
            ],
            [
                'name' => 'Philippine Foremost Milling Corporation',
                'department' => 'Feed',
                'abbrv' => 'PFMCFE'
            ],
            [
                'name' => 'La Filipina Uy Gongco Corporation',
                'department' => null,
                'abbrv' => 'LFUG'
            ],
            [
                'name' => 'Amigo Logistics Corpotation',
                'department' => null,
                'abbrv' => 'ALC'
            ],
            [
                'name' => 'Philippine Leading Infinite Logistics Corp',
                'department' => null,
                'abbrv' => 'PLILI'
            ],
            [
                'name' => 'Capiz Sugar Central Inc',
                'department' => null,
                'abbrv' => 'CSCI'
            ],
        ]);
    }
}
