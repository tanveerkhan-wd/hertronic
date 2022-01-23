<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationDegreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('QualificationsDegrees', function (Blueprint $table) {
            $table->integer('pkQde')->autoIncrement();
            $table->string('qde_Uid', 30)->nullable();
            $table->string('qde_QualificationDegreeName_en', 100)->nullable();
            $table->string('qde_QualificationDegreeNameGenitive', 100)->nullable();
            $table->string('qde_QualificationDegreeNameRoman', 100)->nullable();
            $table->string('qde_QualificationDegreeNameNumeric', 100)->nullable();
            $table->text('qde_Notes')->nullable();
            $table->enum('qde_Status', array('Active', 'Inactive'))->default('Active');
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
        Schema::dropIfExists('QualificationsDegrees');
    }
}
