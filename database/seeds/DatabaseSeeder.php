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
    	$this->call(MstOrderStatusSeeder::class);
        $this->call(BalanceTypeSeeder::class);
        $this->call(TransactionTypeSeeder::class);
        $this->call(MstOrderTypeSeeder::class);
    }
}
