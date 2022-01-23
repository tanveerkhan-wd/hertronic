<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SchoolPhotos', function (Blueprint $table) {
            $table->integer('pkSph')->autoIncrement();
            $table->integer('fkSphSch')->nullable();
            $table->string('sph_SchoolPhoto',100)->nullable();
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
        Schema::dropIfExists('SchoolPhotos');
    }
}
