<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('fkAdmCny')->nullable();
            $table->integer('fkAdmCan')->nullable();
            $table->string('adm_Uid', 30)->nullable();
            $table->string('adm_Name', 255)->nullable();
            $table->string('adm_Photo', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->string('adm_Title', 255)->nullable();
            $table->string('adm_Phone', 255)->nullable();
            $table->string('adm_GovId', 255)->nullable();
            $table->enum('adm_Gender', array('Male', 'Female'));
            $table->dateTime('adm_DOB')->nullable();
            $table->string('adm_Address', 255)->nullable();
            $table->string('email_verification_key', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('adm_Status', array('Active', 'Inactive'))->default('Active');
            $table->enum('type', array('HertronicAdmin', 'MinistryAdmin', 'MinistrySubAdmin'));
            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('admin');
    }
}
