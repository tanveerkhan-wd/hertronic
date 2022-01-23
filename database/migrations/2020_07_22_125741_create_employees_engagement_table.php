<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesEngagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EmployeesEngagement', function (Blueprint $table) {
            $table->integer('pkEen')->autoIncrement();
            $table->integer('fkEenSch')->nullable();
            $table->integer('fkEenEmp')->nullable();
            $table->integer('fkEenEty')->nullable();
            $table->integer('fkEenEpty')->nullable();
            $table->enum('een_Intern', ['Yes','No'])->default('No');
            $table->dateTime('een_DateOfEngagement')->nullable();
            $table->dateTime('een_DateOfFinishEngagement')->nullable();
            $table->string('een_WeeklyHoursRate',100)->nullable();
            $table->text('een_Notes')->nullable();
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
        Schema::dropIfExists('EmployeesEngagement');
    }
}
