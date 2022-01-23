<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StudentEnrollments', function (Blueprint $table) {
            $table->increments('pkSte',11);
            $table->integer('fkSteStu',11)->nullable();
            $table->integer('fkSteMbo',11)->nullable();
            $table->integer('fkSteGra',11)->nullable();
            $table->integer('fkSteEdp',11)->nullable();
            $table->integer('fkSteEpl',11)->nullable();
            $table->integer('fkSteSye',11)->nullable();
            $table->string('ste_DistanceInKilometers',30)->nullable();
            $table->integer('ste_MainBookOrderNumber',11)->nullable();
            $table->dateTime('ste_EnrollmentDate')->nullable();
            $table->text('ste_EnrollBasedOn')->nullable();
            $table->text('ste_Reason')->nullable();
            $table->dateTime('ste_FinishingDate')->nullable();
            $table->dateTime('ste_BreakingDate')->nullable();
            $table->dateTime('ste_ExpellingDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('StudentEnrollments');
    }
}
