<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstPlaceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_place_categories', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');

            $table->string("name_en")->nullable();
            $table->string("name_vi")->nullable();
            $table->char("icon_id", 32)->nullable();
            $table->char("parent_id", 32)->nullable();
            
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
        Schema::dropIfExists('mst_place_categories');
    }
}
