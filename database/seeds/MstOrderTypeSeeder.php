<?php

use Illuminate\Database\Seeder;
use App\Models\MstOrderType;

class MstOrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MstOrderType::truncate();

        MstOrderType::create(["name_vi" => "Admin tạo", "name_en" => "Created by Admin"]);
        MstOrderType::create(["name_vi" => "Thanh toán trực tiếp", "name_en" => "Pay direct to partner"]);
        MstOrderType::create(["name_vi" => "Partner tạo", "name_en" => "Created by Partner"]);
        MstOrderType::create(["name_vi" => "Tạo qua App", "name_en" => "Created via App"]);
        MstOrderType::create(["name_vi" => "Đại lý tạo", "name_en" => "Created by Affiliate"]);
    }
}
