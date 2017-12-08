<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusPricesetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_pricesets', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');

            $table->char('provider_id', 32)->nullable();

            $table->text("name_en", 32)->nullable();
            $table->text("name_vi", 32)->nullable();

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
        Schema::dropIfExists('bus_pricesets');
    }
}
