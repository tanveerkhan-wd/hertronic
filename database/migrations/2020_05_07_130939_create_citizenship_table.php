<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitizenshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Citizenships', function (Blueprint $table) {
            $table->integer('pkCtz')->autoIncrement();
            $table->integer('fkCtzCny')->nullable();
            $table->string('ctz_Uid', 30)->nullable();
            $table->string('ctz_CitizenshipName_en', 50)->nullable();
            $table->text('ctz_Notes')->nullable();
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
        Schema::dropIfExists('Citizenships');
    }
}
