<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');

            $table->char('order_id', 32)->nullable();
            $table->date('start_date')->nullable();

            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();

            $table->decimal("price", 14, 4)->nullable()->default(0);
            $table->decimal("price_bwhere", 14, 4)->nullable()->default(0);
            $table->decimal("price_direct", 14, 4)->nullable()->default(0);

            $table->string('info_type')->nullable();
            $table->char('info_id', 32)->nullable();

            $table->string('product_type')->nullable();
            $table->char('product_id', 32)->nullable();

            $table->char('group_code', 32);

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
        Schema::dropIfExists('order_items');
    }
}
