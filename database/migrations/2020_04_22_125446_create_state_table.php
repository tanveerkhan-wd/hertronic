<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->integer('pkSta')->autoIncrement();
            $table->integer('fkStaCny')->nullable();
            $table->string('sta_Uid', 30)->nullable();
            $table->string('sta_StateName_en', 100)->nullable();
            $table->string('sta_StateNameGenitive', 100)->nullable();
            $table->text('sta_Note')->nullable();
            $table->enum('sta_Status', array('Active', 'Inactive'))->default('Active');
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
        Schema::dropIfExists('states');
    }
}
