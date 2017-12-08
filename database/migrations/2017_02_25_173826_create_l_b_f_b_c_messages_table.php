<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLBFBCMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LBFBC_messages', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');
            $table->string('mid')->nullable();

            $table->char('sender_id', 32)->nullable();
            $table->char('receiver_id', 32)->nullable();
            $table->char('conversation_id', 32)->nullable();

            $table->text('message')->nullable();
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
        Schema::dropIfExists('LBFBC_messages');
    }
}
