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
            [
                'user_id' => 1,
                'name' => 'Bank of the Philippine Islands',
                'branch' => 'Plaza Cervantes Branch',
                'location' => 'Manila',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'name' => 'Bank of the Philippine Islands',
                'branch' => 'Central Market Branch',
                'location' => 'Manila',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'name' => 'Metropolitan Bank and Trust Company',
                'branch' => 'Taft Avenue Branch',
                'location' => 'Manila',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
        ]);
    }
}
