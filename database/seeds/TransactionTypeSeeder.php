<?php

use Illuminate\Database\Seeder;
use App\Models\Transaction_type;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction_type::truncate();

        Transaction_type::create(["name_vi" => "Nạp tiền", "name_en" => "Deposit"]);
        Transaction_type::create(["name_vi" => "Chuyển tiền", "name_en" => "Transfer"]);
        Transaction_type::create(["name_vi" => "Rút tiền", "name_en" => "Withdrawal"]);
    }
}
