<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelPricesetWeekdayysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_priceset_weekdays', function (Blueprint $table) {
            $table->increments('id');
            $table->char('hotel_id', 32)->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            
            $table->date('start_date');
            $table->char('monday_priceset_id', 32)->nullable();
            $table->char('tuesday_priceset_id', 32)->nullable();
            $table->char('wednesday_priceset_id', 32)->nullable();
            $table->char('thursday_priceset_id', 32)->nullable();
            $table->char('friday_priceset_id', 32)->nullable();
            $table->char('saturday_priceset_id', 32)->nullable();
            $table->char('sunday_priceset_id', 32)->nullable();
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
        Schema::dropIfExists('hotel_priceset_weekdays');
    }
}
