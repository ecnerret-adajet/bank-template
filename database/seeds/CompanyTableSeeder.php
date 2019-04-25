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
                'id' => 1,
                'name' => 'Philippine Foremost Milling Corporation',
                'abbrv' => 'PFMCFL',
                'department' => 'Flour',
                'avatar' => 'companies/pfmc.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'Philippine Foremost Milling Corporation',
                'department' => 'Feed',
                'abbrv' => 'PFMCFE',
                'avatar' => 'companies/pfmc.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 3,
                'name' => 'La Filipina Uy Gongco Corporation',
                'department' => null,
                'abbrv' => 'LFUG',
                'avatar' => 'companies/lfug.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 4,
                'name' => 'Amigo Logistics Corpotation',
                'department' => null,
                'abbrv' => 'ALC',
                'avatar' => 'companies/alc.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 5,
                'name' => 'Philippine Leading Infinite Logistics Corp',
                'department' => null,
                'abbrv' => 'PLILI',
                'avatar' => 'companies/plili.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 6,
                'name' => 'Capiz Sugar Central Inc',
                'department' => null,
                'abbrv' => 'CSCI',
                'avatar' => 'companies/csci.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 7,
                'name' => 'La Filipina Meats',
                'department' => null,
                'abbrv' => 'LAFIL MEATS',
                'avatar' => 'companies/lfug.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 8,
                'name' => 'Mama Tina Pasta Inc.',
                'department' => null,
                'abbrv' => 'MAMATINA',
                'avatar' => 'companies/lfug.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 9,
                'name' => 'Amigo Shipping Corporation',
                'department' => null,
                'abbrv' => 'ASC',
                'avatar' => 'companies/lfug.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 10,
                'name' => 'Daruma Transport - Iloilo',
                'department' => null,
                'abbrv' => 'Daruma',
                'avatar' => 'companies/lfug.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 11,
                'name' => 'Mindanao - Manila',
                'department' => null,
                'abbrv' => 'Daruma',
                'avatar' => 'companies/lfug.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'id' => 12,
                'name' => 'Mariveles Grains Corporation',
                'department' => null,
                'abbrv' => 'MGC',
                'avatar' => 'companies/lfug.png',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
        ]);
    }
}
