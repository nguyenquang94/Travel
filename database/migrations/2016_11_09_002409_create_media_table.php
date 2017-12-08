<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->char('id', 32);

            $table->string('mime_type', 32);
            $table->string('original_name');
            $table->string('original_extension', 32);
            $table->integer('size');

            // for image

            $table->integer("width")->nullable();
            $table->integer("height")->nullable();
            $table->string("scale_type")->nullable();
            $table->char("original_id", 32)->nullable();
            

            $table->char('updated_by', 32)->nullable();
            $table->char('created_by', 32)->nullable();
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
        Schema::dropIfExists('media');
    }
}
