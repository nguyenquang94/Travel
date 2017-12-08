<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelPricesetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_priceset_items', function (Blueprint $table) {
            $table->increments('id');
            $table->char('priceset_id', 32)->nullable();
            $table->char('room_type_id', 32)->nullable();
            $table->decimal("price", 14, 4)->default(0);
            $table->decimal("price_bwhere", 14, 4)->default(0);
            $table->decimal("price_direct", 14, 4)->default(0);
            $table->integer('currency_id')->default(1);

            $table->char('created_by', 32)->nullable();
            $table->char('updated_by', 32)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_priceset_items');
    }
}
