<?php

use Illuminate\Database\Seeder;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('managers')->insert([
            [
                'bank_id' => 1,
                'title' => 'Ms.',
                'first_name' => 'Marie Jessica',
                'middle_name' => 'P',
                'last_name' => 'Calma',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'bank_id' => 2,
                'title' => 'Ms.',
                'first_name' => 'Marissa',
                'middle_name' => 'P',
                'last_name' => 'Suegay',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ]
        ]);
    }
}
