<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('JobAndWork', function (Blueprint $table) {
            $table->integer('pkJaw')->autoIncrement();
            $table->string('jaw_Uid', 30)->nullable();
            $table->string('jaw_Name_en', 100)->nullable();
            $table->text('jaw_Notes')->nullable();
            $table->enum('jaw_Status', array('Active', 'Inactive'))->default('Active');
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
        Schema::dropIfExists('JobAndWork');
    }
}
