<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id');
            $table->bigInteger('worker_id');
            $table->enum('addressType', ['PE','PR'])->default('PE');
            $table->string('village', 255);
            $table->string('postoffice', 255);
            $table->string('policestation', 255);
            $table->string('district', 255);
            $table->string('near_by', 255);
            $table->string('state', 255);
            $table->string('pincode', 255);
            $table->enum('status', ['0','1'])->default('0');
            $table->date('stay')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
