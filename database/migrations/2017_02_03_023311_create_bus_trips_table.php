<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_trips', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');

            $table->text("name_vi", 32)->nullable();
            $table->text("name_en", 32)->nullable();

            $table->date("start_date")->nullable();
            $table->time("start_time")->nullable();

            $table->date("eta_date")->nullable();
            $table->time("eta_time")->nullable();

            $table->char('provider_id', 32)->nullable();
            $table->char('type_id', 32)->nullable();
            $table->char('priceset_id', 32)->nullable();

            $table->char("created_by", 32)->nullable();
            $table->char("updated_by", 32)->nullable();
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
        Schema::dropIfExists('bus_trips');
    }
}
