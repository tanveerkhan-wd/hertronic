<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Universities', function (Blueprint $table) {
            $table->integer('pkUni')->autoIncrement();
            $table->integer('fkUniCny')->nullable();
            $table->integer('fkUniOty')->nullable();
            $table->string('uni_Uid', 30)->nullable();
            $table->string('uni_UniversityName_en', 100)->nullable();
            $table->string('uni_YearStartedFounded', 50)->nullable();
            $table->text('uni_PicturePath')->nullable();
            $table->text('uni_Notes')->nullable();
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
        Schema::dropIfExists('Universities');
    }
}
