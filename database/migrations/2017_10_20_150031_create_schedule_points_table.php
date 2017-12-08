<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_points', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');

            $table->char('schedule_id', 32)->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_vi')->nullable();

            $table->time('estimated_time')->nullable();
            $table->integer('estimated_day')->nullable();
            $table->decimal('estimated_cost', 14, 4)->nullable();
            $table->decimal('estimated_distance')->nullable();

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
        Schema::dropIfExists('schedule_points');
    }
}
