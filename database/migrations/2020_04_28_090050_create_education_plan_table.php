<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('NationalEducationPlans', function (Blueprint $table) {
            $table->integer('pkNep')->autoIncrement();
            $table->string('nep_Uid', 30)->nullable();
            $table->string('nep_NationalEducationPlanName_en', 100)->nullable();
            $table->text('nep_Notes')->nullable();
            $table->enum('nep_Status', array('Active', 'Inactive'))->default('Active');
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
        Schema::dropIfExists('NationalEducationPlans');
    }
}
