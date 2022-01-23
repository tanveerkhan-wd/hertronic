<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Courses', function (Blueprint $table) {
            $table->integer('pkCrs')->autoIncrement();
            $table->string('crs_Uid', 10)->nullable();
            $table->string('crs_CourseName_en', 100)->nullable();
            $table->string('crs_CourseAlternativeName', 100)->nullable();
            $table->enum('crs_CourseType', array('General', 'Specialization'))->default('General');
            $table->enum('crs_IsForeignLanguage', array('Yes', 'No'))->default('No');
            $table->text('crs_Notes')->nullable();
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
        Schema::dropIfExists('Courses');
    }
}
