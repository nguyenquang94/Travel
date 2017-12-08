<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_transaction_categories', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');

            $table->string("name_en");
            $table->string("name_vi");

            $table->char('parent_id', 32)->nullable();

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
        Schema::dropIfExists('mst_transaction_categories');
    }
}
