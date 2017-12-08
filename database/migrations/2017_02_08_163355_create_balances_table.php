<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->char('id');
            $table->primary('id');

            $table->char('user_id')->nullable();
            $table->decimal('amount', 14, 4)->nullable();

            $table->integer('type_id');
            $table->integer('status_id');

            $table->char('bank_id', 32)->nullable();
            $table->string('bank_number')->nullable();
            $table->string('bank_holder_name')->nullable();
            $table->string('bank_branch')->nullable();

            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
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
        Schema::dropIfExists('balances');
    }
}
