<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignLanguageGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ForeignLanguageGroups', function (Blueprint $table) {
            $table->increments('pkFon',11);
            $table->string('fon_Uid',30)->nullable();
            $table->string('fon_Name_en',100)->nullable();
            $table->text('fon_Notes')->nullable();
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
        Schema::dropIfExists('ForeignLanguageGroups');
    }
}
