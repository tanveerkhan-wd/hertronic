<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDesignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EmployeeDesignations', function (Blueprint $table) {
            $table->integer('pkEde')->autoIncrement();
            $table->string('ede_EmployeeDesignationName_en',255)->nullable();
            $table->text('ede_Notes')->nullable();
            $table->enum('ede_Status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('EmployeeDesignations');
    }
}
