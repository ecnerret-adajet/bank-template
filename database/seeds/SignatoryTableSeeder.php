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
                'last_name' => 'Ongkauko',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Ian Kenneth',
                'middle_name' => 'O',
                'last_name' => 'Uygongco',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Donnable',
                'middle_name' => 'P',
                'last_name' => 'Pasquin',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ]
        ]);
    }
}
