<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolEducationPlanAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SchoolEducationPlanAssignment', function (Blueprint $table) {
            $table->integer('pkSep')->autoIncrement();
            $table->integer('fkSepSch')->nullable();
            $table->integer('fkSepEdp')->nullable();
            $table->integer('fkSepEpl')->nullable();
            $table->dateTime('sep_DateOfAccreditation')->nullable();
            $table->enum('sep_Status', ['Active','Inactive'])->default('Active');
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
        Schema::dropIfExists('SchoolEducationPlanAssignment');
    }
}
