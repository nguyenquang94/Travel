<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');
            $table->integer('type_id')->nullable();
            $table->integer('status_id')->nullable();

            $table->decimal('amount', 14, 4)->nullable();
            $table->char('from_id', 32)->nullable();
            $table->char('to_id', 32)->nullable();
            $table->char('category_id', 32)->nullable();

            $table->char('created_by', 32)->nullable();
            $table->char('updated_by_id', 32)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
