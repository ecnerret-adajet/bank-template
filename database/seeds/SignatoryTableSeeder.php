<?php

use Illuminate\Database\Seeder;

class SignatoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('signatories')->insert([
            [
                'user_id' => 1,
                'first_name' => 'Aileen Christel',
                'middle_name' => 'Uygongco',
                'last_name' => 'Ongkauko'
            ],
            [
                'user_id' => 1,
                'first_name' => 'Ian Kenneth',
                'middle_name' => 'O',
                'last_name' => 'Uygongco'
            ]
        ]);
    }
}
