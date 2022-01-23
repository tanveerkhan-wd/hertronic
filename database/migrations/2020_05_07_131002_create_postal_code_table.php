<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostalCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PostOffices', function (Blueprint $table) {
            $table->integer('pkPof')->autoIncrement();
            $table->integer('fkPofMun')->nullable();
            $table->string('pof_Uid', 30)->nullable();
            $table->string('pof_PostOfficeName_en', 50)->nullable();
            $table->string('pof_PostOfficeNumber', 50)->nullable();
            $table->text('pof_Notes')->nullable();
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
        Schema::dropIfExists('PostOffices');
    }
}
