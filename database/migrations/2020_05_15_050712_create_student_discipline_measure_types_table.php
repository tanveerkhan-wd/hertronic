<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentDisciplineMeasureTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StudentDisciplineMeasureTypes', function (Blueprint $table) {
            $table->increments('pkSmt',11);
            $table->string('smt_Uid',30);
            $table->string('smt_DisciplineMeasureName_en',100);
            $table->text('smt_Notes')->nullable();
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
        Schema::dropIfExists('StudentDisciplineMeasureTypes');
    }
}
