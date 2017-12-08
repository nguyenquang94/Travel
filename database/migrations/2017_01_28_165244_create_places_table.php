<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->char('id', 32);
            $table->primary('id');
            
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->text("name_en")->nullable();
            $table->text("name_vi")->nullable();
            $table->text("name_in_url_en")->nullable();
            $table->text("name_in_url_vi")->nullable();
            $table->text("description_en")->nullable();
            $table->text("description_vi")->nullable();
            $table->text("short_description_en")->nullable();
            $table->text("short_description_vi")->nullable();
            $table->text("how_to_go_en")->nullable();
            $table->text("how_to_go_vi")->nullable();
            $table->text("address_en")->nullable();
            $table->text("address_vi")->nullable();
            $table->boolean("enable_en")->nullable();
            $table->boolean("enable_vi")->nullable();

            $table->string("info_type")->nullable();
            $table->char("info_id", 32)->nullable();

            $table->char("category_id", 32)->nullable();
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
        Schema::dropIfExists('places');
    }
}
