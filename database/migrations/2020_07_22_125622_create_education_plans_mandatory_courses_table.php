<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationPlansMandatoryCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EducationPlansMandatoryCourses', function (Blueprint $table) {
            $table->integer('pkEmc')->autoIncrement();
            $table->integer('fkEmcEpl')->nullable();
            $table->integer('fkEplCrs')->nullable();
            $table->integer('emc_hours')->nullable();
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
        Schema::dropIfExists('EducationPlansMandatoryCourses');
    }
}
