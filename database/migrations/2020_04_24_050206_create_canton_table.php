<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCantonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cantons', function (Blueprint $table) {
            $table->integer('pkCan')->autoIncrement();
            $table->integer('fkCanSta')->nullable();
            $table->string('can_Uid', 30)->nullable();
            $table->string('can_CantonName_en', 100)->nullable();
            $table->string('can_CantonNameGenitive', 100)->nullable();
            $table->text('can_Note')->nullable();
            $table->enum('can_Status', array('Active', 'Inactive'))->default('Active');
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
        Schema::dropIfExists('cantons');
    }
}
