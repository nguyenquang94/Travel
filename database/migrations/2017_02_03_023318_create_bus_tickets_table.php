<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_tickets', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');

            $table->char('trip_id', 32)->nullable();

            $table->decimal("price", 14, 4)->default(0);
            $table->decimal("price_bwhere", 14, 4)->default(0);
            $table->decimal("price_direct", 14, 4)->default(0);
            $table->integer('currency_id')->default(1);

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
        Schema::dropIfExists('bus_tickets');
    }
}
