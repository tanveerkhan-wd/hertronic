<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationPeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_period', function (Blueprint $table) {
            $table->increments('pkEdp');
            $table->string('edp_Uid')->nullable();
            $table->string('edp_EducationPeriodName_en')->nullable();
            $table->year('edp_EducationPeriodNameAdjective')->nullable();
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
        Schema::dropIfExists('education_period');
    }
}
