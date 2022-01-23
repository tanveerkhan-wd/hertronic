<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EducationPrograms', function (Blueprint $table) {
            $table->increments('pkEdp',11);
            $table->string('edp_Uid',30)->nullable();
            $table->string('edp_Name_en',100)->nullable();
            $table->integer('edp_ParentId')->nullable();
            $table->text('edp_Notes')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('EducationPrograms');
    }
}
