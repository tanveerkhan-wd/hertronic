<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Students', function (Blueprint $table) {
            $table->integer('pkStu',11)->autoIncrement();
            $table->integer('fkStuMun',11)->nullable();
            $table->integer('fkStuPof',11)->nullable();
            $table->integer('fkStuNat',11)->nullable();
            $table->integer('fkStuRel',11)->nullable();
            $table->integer('fkStuCtz',11)->nullable();
            $table->integer('fkStuFatherJaw',11)->nullable();
            $table->integer('fkStuMotherJaw',11)->nullable();
            $table->string('stu_StudentID',13)->nullable();
            $table->string('stu_TempCitizenId',13)->nullable();
            $table->string('stu_StudentName',255)->nullable();
            $table->string('stu_StudentSurname',255)->nullable();
            $table->dateTime('stu_DateOfBirth')->nullable();
            $table->string('stu_PlaceOfBirth',255)->nullable();
            $table->enum('stu_StudentGender', ['Male', 'Female', 'Other'])->default('Male');
            $table->string('stu_Address',255)->nullable();
            $table->string('stu_DistanceInKilometers',255)->nullable();
            $table->string('stu_Email',255)->nullable();
            $table->string('stu_PhoneNumber',255)->nullable();
            $table->string('stu_MobilePhoneNumber',255)->nullable();
            $table->string('stu_FatherName',255)->nullable();
            $table->string('stu_MotherName',255)->nullable();
            $table->string('stu_ParentsEmail',255)->nullable();
            $table->string('stu_ParantsPhone',100)->nullable();
            $table->enum('stu_SpecialNeed', ['Yes', 'No'])->default('Yes');
            $table->string('stu_PicturePath',255)->nullable();
            $table->string('stu_Notes',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
