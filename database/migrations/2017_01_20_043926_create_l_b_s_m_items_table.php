<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLBSMItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LBSM_items', function (Blueprint $table) {
            $table->char('id', 32);

            $table->string('title');
            $table->boolean('title_translated')->default(false);

            $table->string('icon');
            $table->string('url');
            $table->string('id_string');

            $table->integer('order_number')->default(0);
            $table->char('parent_id', 32)->nullable();

            $table->char('created_by', 32)->nullable();
            $table->char('updated_by', 32)->nullable();
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LBSM_items');
    }
}
