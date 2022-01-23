<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Vocations', function (Blueprint $table) {
            $table->integer('pkVct')->autoIncrement();
            $table->string('vct_Uid', 30)->nullable();
            $table->string('vct_VocationName_en', 100)->nullable();
            $table->text('vct_Notes')->nullable();
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
        Schema::dropIfExists('Vocations');
    }
}
