<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MainBooks', function (Blueprint $table) {
            $table->integer('pkMbo')->autoIncrement();
            $table->integer('fkMboSch')->nullable();
            $table->string('mbo_Uid',30)->nullable();
            $table->string('mbo_MainBookNameRoman',255)->nullable();
            $table->dateTime('mbo_OpeningDate')->nullable();
            $table->text('mbo_Notes')->nullable();
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
        Schema::dropIfExists('MainBooks');
    }
}
