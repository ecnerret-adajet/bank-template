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
                'last_name' => 'Calma'
            ],
            [
                'bank_id' => 2,
                'title' => 'Ms.',
                'first_name' => 'Marissa',
                'middle_name' => 'P',
                'last_name' => 'Suegay'
            ]
        ]);
    }
}
