<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassTeachersAndCourseAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ClassTeachersAndCourseAllocation', function (Blueprint $table) {
            $table->integer('pkCtc')->autoIncrement();
            $table->integer('fkCtcClr')->nullable();
            $table->integer('fkCtcEmc')->nullable();
            $table->integer('fkCtcEeg')->nullable();
            $table->enum('ctc_SubClass', ['Yes', 'No'])->default('No');
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
        Schema::dropIfExists('ClassTeachersAndCourseAllocation');
    }
}
