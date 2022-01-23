<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnershipTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OwnershipTypes', function (Blueprint $table) {
            $table->integer('pkOty')->autoIncrement();
            $table->string('oty_Uid', 30)->nullable();
            $table->string('oty_OwnershipTypeName_en', 100)->nullable();
            $table->text('oty_Notes')->nullable();
            $table->enum('oty_Status', array('Active', 'Inactive'))->default('Active');
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
        Schema::dropIfExists('OwnershipTypes');
    }
}
