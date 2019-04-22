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
                'company_id' => 7,
                'account_number' => '4763 0575 13',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 1,
                'company_id' => 4,
                'account_number' => '0053 6568 46',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 1,
                'company_id' => 8,
                'account_number' => '0053 4175 66',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 2,
                'company_id' => 3,
                'account_number' => '9225 8071 64',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 2,
                'company_id' => 1,
                'account_number' => '9225 9110 64',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 2,
                'company_id' => 9,
                'account_number' => '9220 0033 42',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 2,
                'company_id' => 10,
                'account_number' => '9220 0041 01',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 3,
                'company_id' => 3,
                'account_number' => '0773 0775 0888 1',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 3,
                'company_id' => 1,
                'account_number' => '0773 0775 0882 2',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 3,
                'company_id' => 1,
                'account_number' => '0773 0775 0887 3',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 3,
                'company_id' => 11,
                'account_number' => '0773 0772 8358 8',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 3,
                'company_id' => 11,
                'account_number' => '0777 0772 8338 3',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 3,
                'company_id' => 11,
                'account_number' => '0777 0775 1142 0',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 3,
                'company_id' => 5,
                'account_number' => '0777 0775 1142 0',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
            [
                'user_id' => 1,
                'bank_id' => 3,
                'company_id' => 8,
                'account_number' => '0777 0775 1308 2',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ],
        ]);
    }
}
