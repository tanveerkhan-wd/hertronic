<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Colleges', function (Blueprint $table) {
            $table->integer('pkCol')->autoIncrement();
            $table->integer('fkColUni')->nullable();
            $table->integer('fkColCny')->nullable();
            $table->integer('fkColOty')->nullable();
            $table->string('col_Uid', 30)->nullable();
            $table->string('col_CollegeName_en', 250)->nullable();
            $table->string('col_YearStartedFounded', 50)->nullable();
            $table->enum('col_BelongsToUniversity', array('Yes', 'No'))->default('No');
            $table->string('col_PicturePath',250)->nullable();
            $table->text('col_Notes')->nullable();
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
        Schema::dropIfExists('Colleges');
    }
}
