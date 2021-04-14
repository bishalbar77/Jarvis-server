<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employeId');
            $table->bigInteger('companyId');
            $table->integer('empType');
            $table->bigInteger('salary');
            $table->string('phoneNo', 15);
            $table->dateTime('doj')->nullable();
            $table->dateTime('dor')->nullable();
            $table->enum('verifyStatus', ['0','1'])->default('0');
            $table->enum('employmentStatus', ['0','1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employment_histories');
    }
}
