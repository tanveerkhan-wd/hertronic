<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Schools', function (Blueprint $table) {
            $table->integer('pkSch')->autoIncrement();
            $table->integer('fkSchPof')->nullable();
            $table->integer('fkSchOty')->nullable();
            $table->string('sch_Uid',30)->nullable();
            $table->string('sch_SchoolLogo',255)->nullable();
            $table->string('sch_SchoolName_en',200)->nullable();
            $table->string('sch_SchoolId',50)->nullable();
            $table->string('sch_SchoolEmail',100)->nullable();
            $table->string('sch_Founder',255)->nullable();
            $table->dateTime('sch_FoundingDate')->nullable();
            $table->string('sch_Address',255)->nullable();
            $table->string('sch_PhoneNumber',255)->nullable();
            $table->string('sch_MinistryApprovalCertificate',255)->nullable();
            $table->text('sch_AboutSchool')->nullable();
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
        Schema::dropIfExists('Schools');
    }
}
