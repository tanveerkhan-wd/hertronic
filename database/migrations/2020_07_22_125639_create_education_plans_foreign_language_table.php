<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationPlansForeignLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EducationPlansForeignLanguage', function (Blueprint $table) {
            $table->integer('pkEfl')->autoIncrement();
            $table->integer('fkEflEpl')->nullable();
            $table->integer('fkEflCrs')->nullable();
            $table->string('efc_hours',50)->nullable();
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
        Schema::dropIfExists('EducationPlansForeignLanguage');
    }
}
