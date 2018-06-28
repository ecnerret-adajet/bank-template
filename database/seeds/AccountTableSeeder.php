<?php

use Illuminate\Database\Seeder;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            [
                'user_id' => 1,
                'bank_id' => 1,
                'company_id' => 1,
                'account_number' => '0051 0540 08',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 2,
                'company_id' => 1,
                'account_number' => '2093 0855 77',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 1,
                'company_id' => 2,
                'account_number' => '0051 0540 90',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 2,
                'company_id' => 2,
                'account_number' => '0046 6124 97',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 1,
                'company_id' => 3,
                'account_number' => '3123 5123 64',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 2,
                'company_id' => 3,
                'account_number' => '8245 1685 43',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
        ]);
    }
}
