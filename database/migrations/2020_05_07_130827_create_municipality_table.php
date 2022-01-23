<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipalityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Municipalities', function (Blueprint $table) {
            $table->integer('pkMun')->autoIncrement();
            $table->integer('fkMunCan')->nullable();
            $table->string('mun_Uid', 30)->nullable();
            $table->string('mun_MunicipalityName_en', 100)->nullable();
            $table->string('mun_MunicipalityNameGenitive', 100)->nullable();
            $table->text('mun_Notes')->nullable();
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
        Schema::dropIfExists('Municipalities');
    }
}
