<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultativeCoursesGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FacultativeCoursesGroups', function (Blueprint $table) {
            $table->increments('pkFcg',11);
            $table->string('fcg_Uid',30)->nullable();
            $table->string('fcg_Name_en',100)->nullable();
            $table->text('fcg_Notes')->nullable();
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
        Schema::dropIfExists('FacultativeCoursesGroups');
    }
}
