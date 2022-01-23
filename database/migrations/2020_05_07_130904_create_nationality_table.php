<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNationalityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Nationalities', function (Blueprint $table) {
            $table->integer('pkNat')->autoIncrement();
            $table->string('nat_Uid', 30)->nullable();
            $table->string('nat_NationalityName_en', 50)->nullable();
            $table->string('nat_NationalityNameMale', 50)->nullable();
            $table->string('nat_NationalityNameFemale', 50)->nullable();
            $table->text('nat_Notes')->nullable();
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
        Schema::dropIfExists('Nationalities');
    }
}
