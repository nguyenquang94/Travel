<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');

            $table->text('name_en')->nullable();
            $table->text('name_vi')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_vi')->nullable();
            $table->string('estimated_time')->nullable();
            $table->string('estimated_cost')->nullable();
            $table->string('traffic_en')->nullable();
            $table->string('traffic_vi')->nullable();

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
        Schema::dropIfExists('schedules');
    }
}
