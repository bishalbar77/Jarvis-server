<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('worker_id');
            $table->bigInteger('company_id');
            $table->string('additional_amount', 25);
            $table->string('additional_amount_status', 25);
            $table->string('payment_request_id', 25);
            $table->string('temp_id', 25);
            $table->string('discount', 25);
            $table->string('promocode', 25);
            $table->string('gst', 25);
            $table->string('subTotal', 25);
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
        Schema::dropIfExists('payment_histories');
    }
}
