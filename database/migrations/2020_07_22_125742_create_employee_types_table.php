<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EmployeeTypes', function (Blueprint $table) {
            $table->integer('pkEpty')->autoIncrement();
            $table->enum('epty_Name', ['Yes','No'])->default('No');
            $table->integer('epty_ParentId')->nullable();
            $table->string('epty_subCatName',255)->nullable();
            $table->text('epty_Notes')->nullable();
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
        Schema::dropIfExists('EmployeeTypes');
    }
}
