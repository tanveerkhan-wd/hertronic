<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicDegreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AcademicDegrees', function (Blueprint $table) {
            $table->integer('pkAcd')->autoIncrement();
            $table->string('acd_Uid', 30)->nullable();
            $table->string('acd_AcademicDegreeName_en', 100)->nullable();
            $table->text('acd_Notes')->nullable();
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
        Schema::dropIfExists('AcademicDegrees');
    }
}
