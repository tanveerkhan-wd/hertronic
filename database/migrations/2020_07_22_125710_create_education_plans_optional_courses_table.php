<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationPlansOptionalCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EducationPlansOptionalCourses', function (Blueprint $table) {
            $table->integer('pkEoc')->autoIncrement();
            $table->integer('fkEocEpl')->nullable();
            $table->integer('fkEocCrs')->nullable();
            $table->string('eoc_hours',50)->nullable();
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
        Schema::dropIfExists('EducationPlansOptionalCourses');
    }
}
