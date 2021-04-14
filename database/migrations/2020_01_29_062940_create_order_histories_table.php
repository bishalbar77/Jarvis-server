<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->bigInteger('worker_id');
            $table->bigInteger('company_id');
            $table->bigInteger('verification_type');
            $table->string('verification_amount', 45);
            $table->enum('status', ['0', '1', '2', '3', '4'])->default('0');
            $table->enum('documentRequired', ['0', '1'])->default('0');
            $table->enum('isAddress', ['0', '1'])->default('0');
            $table->string('docIds', 45);
            $table->string('addressIds', 45);
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
        Schema::dropIfExists('order_histories');
    }
}
