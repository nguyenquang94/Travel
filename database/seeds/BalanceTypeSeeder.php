<?php

use Illuminate\Database\Seeder;
use App\Models\Balance_type;

class BalanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Balance_type::truncate();

        Balance_type::create(["name_en" => "System account", "name_vi" => "Tài khoản hệ thống"]);
        Balance_type::create(["name_en" => "Virtual account", "name_vi" => "Tài khoản ảo"]);
        Balance_type::create(["name_en" => "Primary account", "name_vi" => "Tài khoản chính"]);
        Balance_type::create(["name_en" => "Secondary account", "name_vi" => "Tài khoản phụ"]);
    }
}
