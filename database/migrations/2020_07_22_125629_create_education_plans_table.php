<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EducationPlans', function (Blueprint $table) {
            $table->integer('pkEpl')->autoIncrement();
            $table->integer('fkEplEdp')->nullable();
            $table->integer('fkEplNep')->nullable();
            $table->integer('fkEplEpr')->nullable();
            $table->integer('fkEplQde')->nullable();
            $table->integer('fkEplGra')->nullable();
            $table->string('epl_Uid',30)->nullable();
            $table->string('epl_EducationPlanName_en',200)->nullable();
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
        Schema::dropIfExists('EducationPlans');
    }
}
