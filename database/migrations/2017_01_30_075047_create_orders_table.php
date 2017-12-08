<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');

            $table->decimal("total_price", 14, 4)->nullable()->default(0);
            $table->decimal("total_price_bwhere", 14, 4)->nullable()->default(0);
            $table->decimal("total_price_direct", 14, 4)->nullable()->default(0);
            $table->char("system_balance_id", 32)->nullable();
            $table->string('name')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('email')->nullable();
            $table->text('note')->nullable();

            $table->char("user_id", 32)->nullable();

            $table->integer('status_id')->default(1);
            $table->integer('type_id')->default(0);

            $table->timestamp('confirmed_at')->nullable();

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
        Schema::dropIfExists('orders');
    }
}
