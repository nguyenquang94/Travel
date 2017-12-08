<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLBCoreLibraryCommandParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LBCore_library_command_params', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');
            $table->char('command_id', 32)->nullable();
            $table->string('param')->nullable();
            $table->string('value')->nullable();
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
        Schema::dropIfExists('LBCore_library_command_params');
    }
}
