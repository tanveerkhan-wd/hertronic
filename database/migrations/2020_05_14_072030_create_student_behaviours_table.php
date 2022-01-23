<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentBehavioursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StudentBehaviours', function (Blueprint $table) {
            $table->increments('pkSbe',11);
            $table->string('sbe_Uid',30)->nullable();
            $table->string('sbe_BehaviourName_en',100)->nullable();
            $table->text('sbe_Notes')->nullable();
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
        Schema::dropIfExists('StudentBehaviours');
    }
}
