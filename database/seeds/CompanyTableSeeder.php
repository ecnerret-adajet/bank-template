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
                'department' => 'Flour',
                'avatar' => 'companies/pfmc.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'name' => 'Philippine Foremost Milling Corporation',
                'department' => 'Feed',
                'abbrv' => 'PFMCFE',
                'avatar' => 'companies/pfmc.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'name' => 'La Filipina Uy Gongco Corporation',
                'department' => null,
                'abbrv' => 'LFUG',
                'avatar' => 'companies/lfug.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'name' => 'Amigo Logistics Corpotation',
                'department' => null,
                'abbrv' => 'ALC',
                'avatar' => 'companies/alc.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'name' => 'Philippine Leading Infinite Logistics Corp',
                'department' => null,
                'abbrv' => 'PLILI',
                'avatar' => 'companies/plili.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'name' => 'Capiz Sugar Central Inc',
                'department' => null,
                'abbrv' => 'CSCI',
                'avatar' => 'companies/csci.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
        ]);
    }
}
