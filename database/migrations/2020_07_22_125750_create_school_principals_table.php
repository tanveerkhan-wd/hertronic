<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolPrincipalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SchoolPrincipals', function (Blueprint $table) {
            $table->integer('pkScp')->autoIncrement();
            $table->integer('fkScpEmp')->nullable();
            $table->integer('fkScpSch')->nullable();
            $table->dateTime('scp_StartDate')->nullable();
            $table->dateTime('scp_EndDate')->nullable();
            $table->enum('scp_ActingPrincipal', ['Yes','No'])->default('No');
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
        Schema::dropIfExists('SchoolPrincipals');
    }
}
