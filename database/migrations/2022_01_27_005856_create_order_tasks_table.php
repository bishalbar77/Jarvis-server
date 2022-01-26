<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task_number');
            $table->string('task_display_id');
            $table->string('task_type');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('employer_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('priority');
            $table->string('tat');
            $table->string('status');
            $table->string('received_date');
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
        Schema::dropIfExists('order_tasks');
    }
}
