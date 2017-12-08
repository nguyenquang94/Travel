<?php

use Illuminate\Database\Seeder;
use App\Models\MstOrderStatus;

class MstOrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MstOrderStatus::truncate();

        MstOrderStatus::create(["name_vi" => "Mới tạo", "name_en" => "New"]);
        MstOrderStatus::create(["name_vi" => "Đã gửi đơn hàng", "name_en" => "Order sent"]);
        MstOrderStatus::create(["name_vi" => "Đã chốt", "name_en" => "Confirmed"]);
        MstOrderStatus::create(["name_vi" => "Đã thanh toán", "name_en" => "Paid"]);
        MstOrderStatus::create(["name_vi" => "Đã gửi thông tin", "name_en" => "Information sent"]);
        MstOrderStatus::create(["name_vi" => "Đã hoàn thành", "name_en" => "Completed"]);
        MstOrderStatus::create(["name_vi" => "Huỷ", "name_en" => "Cancelled"]);
    }
}
