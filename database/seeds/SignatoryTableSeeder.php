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
                'first_name' => 'Ethel Joy',
                'middle_name' => 'U',
                'last_name' => 'Valencia',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Cheryl May',
                'middle_name' => 'U',
                'last_name' => 'Chua',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Julian',
                'middle_name' => '',
                'last_name' => 'Uygongco',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Iris',
                'middle_name' => '',
                'last_name' => 'Pama',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Alfonso',
                'middle_name' => '',
                'last_name' => 'Uy',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Supeng',
                'middle_name' => '',
                'last_name' => 'Uy',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Gerald Jone',
                'middle_name' => '',
                'last_name' => 'Uygongco',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Ma. Luisa',
                'middle_name' => '',
                'last_name' => 'Nograles',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Kenneth',
                'middle_name' => '',
                'last_name' => 'Chuang',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Nicasio',
                'middle_name' => '',
                'last_name' => 'Limjap',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'first_name' => 'Claire',
                'middle_name' => '',
                'last_name' => 'Legaspi',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
        ]);
    }
}
