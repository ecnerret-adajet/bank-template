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
                'bank_id' => 1,
                'account_number' => '0051-0540-08',
            ],
            [
                'bank_id' => 1,
                'account_number' => '2093-0855-77',
            ],
            [
                'bank_id' => 1,
                'account_number' => '0051-0540-90',
            ],
            [
                'bank_id' => 1,
                'account_number' => '0046-6124-97'
            ]
        ]);
    }
}
