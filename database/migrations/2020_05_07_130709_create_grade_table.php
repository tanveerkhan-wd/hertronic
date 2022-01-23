<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Grades', function (Blueprint $table) {
            $table->integer('pkGra')->autoIncrement();
            $table->string('gra_Uid', 30)->nullable();
            $table->string('gra_GradeName_en', 100)->nullable();
            $table->string('gra_GradeNameRoman', 50)->nullable();
            $table->text('gra_Notes')->nullable();
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
        Schema::dropIfExists('Grades');
    }
}
