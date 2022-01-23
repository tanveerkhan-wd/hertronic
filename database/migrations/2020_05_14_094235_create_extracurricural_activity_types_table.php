<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtracurricuralActivityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ExtracurricuralActivityType', function (Blueprint $table) {
            $table->increments('pkSat',11);
            $table->string('sat_Uid',30)->nullable();
            $table->string('sat_StudentExtracurricuralActivityName_en',100)->nullable();
            $table->text('sat_Notes')->nullable();
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
        Schema::dropIfExists('ExtracurricuralActivityType');
    }
}
