<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(AccountTableSeeder::class);
        $this->call(ManagerTableSeeder::class);
        $this->call(SignatoryTableSeeder::class);
        $this->call(PayrollTypeTableSeeder::class);
    }
}
