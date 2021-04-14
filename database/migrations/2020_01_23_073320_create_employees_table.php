<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id');
            $table->bigInteger('company_id');
            $table->string('first_name', 150);
            $table->string('middle_name', 150)->nullable();
            $table->string('last_name', 150)->nullable();
            $table->string('alias_name', 150)->nullable();
            $table->integer('worker_type');
            $table->bigInteger('docTypeId');
            $table->string('document_no', 255);
            $table->string('dob', 45)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('doj', 45)->nullable();
            $table->string('salary', 45)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->longText('photo');
            $table->string('other_details', 50);
            $table->enum('status', ['0','1'])->default('0');
            $table->string('temp_id', 50);
            $table->string('additional_temp_id', 50);
            $table->enum('source', ['B','C'])->default('B');
            $table->string('facebook', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->string('google', 255)->nullable();
            $table->enum('empStatus', ['0','1'])->default('0');
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
        Schema::dropIfExists('employees');
    }
}
