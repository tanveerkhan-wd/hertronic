<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Employees', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('fkEmpMun')->nullable();
            $table->integer('fkEmpPof')->nullable();
            $table->integer('fkEmpCny')->nullable();
            $table->integer('fkEmpNat')->nullable();
            $table->integer('fkEmpRel')->nullable();
            $table->integer('fkEmpCtz')->nullable();
            $table->string('emp_EmployeeID',13)->nullable();
            $table->string('emp_EmployeeName',200)->nullable();
            $table->string('emp_TempCitizenId',100)->nullable();
            $table->dateTime('emp_DateOfBirth')->nullable();
            $table->string('emp_PlaceOfBirth',255)->nullable();
            $table->enum('emp_EmployeeGender', ['Male','Female'])->default('Male');
            $table->string('emp_Address',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('email_verification_key',255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255)->nullable();
            $table->string('remember_token',255)->nullable();
            $table->string('emp_PhoneNumber',255)->nullable();
            $table->string('emp_MobilePhoneNumber',255)->nullable();
            $table->string('emp_PicturePath',255)->nullable();
            $table->text('eemp_Notes')->nullable();
            $table->enum('emp_Status', ['Active','Inactive'])->default('Active');
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
        Schema::dropIfExists('Employees');
    }
}
