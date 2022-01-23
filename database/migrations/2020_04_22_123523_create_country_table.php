<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->integer('pkCny')->autoIncrement();
            $table->string('cny_Uid', 30)->nullable();
            $table->string('cny_CountryName_en', 100)->nullable();
            $table->string('cny_CountryNameGenitive', 100)->nullable();
            $table->string('cny_CountryNameDative', 100)->nullable();
            $table->string('cny_CountryNameAdjective', 100)->nullable();
            $table->text('cny_Note')->nullable();
            $table->enum('cny_Status', array('Active', 'Inactive'))->default('Active');
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
