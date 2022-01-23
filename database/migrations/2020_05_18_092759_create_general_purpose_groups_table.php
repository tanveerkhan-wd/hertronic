<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralPurposeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GeneralPurposeGroups', function (Blueprint $table) {
            $table->increments('pkGpg',11);
            $table->string('gpg_Uid',30)->nullable();
            $table->string('gpg_Name_en',100)->nullable();
            $table->text('gpg_Notes')->nullable();
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
        Schema::dropIfExists('GeneralPurposeGroups');
    }
}
