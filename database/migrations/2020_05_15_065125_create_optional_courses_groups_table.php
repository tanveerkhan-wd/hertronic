<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionalCoursesGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OptionalCoursesGroups', function (Blueprint $table) {
            $table->increments('pkOcg',11);
            $table->string('ocg_Uid',30)->nullable();
            $table->string('ocg_Name_en',100)->nullable();
            $table->text('ocg_Notes')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('OptionalCoursesGroups');
    }
}
