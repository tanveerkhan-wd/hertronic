<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesEducationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EmployeesEducationDetails', function (Blueprint $table) {
            $table->integer('pkEed')->autoIncrement();
            $table->integer('fkEedEmp')->nullable();
            $table->integer('fkEedCol')->nullable();
            $table->integer('fkEedUni')->nullable();
            $table->integer('fkEedAcd')->nullable();
            $table->integer('fkEedQde')->nullable();
            $table->integer('fkEedEde')->nullable();
            $table->text('eed_Notes')->nullable();
            $table->string('eed_ShortTitle',255)->nullable();
            $table->tinyInteger('eed_SemesterNumbers',255)->nullable();
            $table->integer('eed_EctsPoints')->nullable();
            $table->string('eed_YearsOfPassing',50)->nullable();
            $table->string('eed_PicturePath',255)->nullable();
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
        Schema::dropIfExists('EmployeesEducationDetails');
    }
}
