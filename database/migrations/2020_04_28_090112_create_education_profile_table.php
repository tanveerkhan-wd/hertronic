<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EducationProfiles', function (Blueprint $table) {
            $table->integer('pkEpr')->autoIncrement();
            $table->string('epr_Uid', 30)->nullable();
            $table->string('epr_EducationProfileName_en', 100)->nullable();
            $table->text('epr_Notes')->nullable();
            $table->enum('epr_Status', array('Active', 'Inactive'))->default('Active');
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
        Schema::dropIfExists('EducationProfiles');
    }
}
