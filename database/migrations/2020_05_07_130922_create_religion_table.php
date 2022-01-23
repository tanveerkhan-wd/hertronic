<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReligionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Religions', function (Blueprint $table) {
            $table->integer('pkRel')->autoIncrement();
            $table->string('rel_Uid', 30)->nullable();
            $table->string('rel_ReligionName_en', 50)->nullable();
            $table->string('rel_ReligionNameAdjective', 50)->nullable();
            $table->text('rel_Notes')->nullable();
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
        Schema::dropIfExists('Religions');
    }
}
