<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('verification_type_id');
            $table->string('fields_name', 255);
            $table->string('fields_type', 255);
            $table->longText('option_value')->nullable();
            $table->enum('status', ['0','1'])->default('0');
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
        Schema::dropIfExists('verification_fields');
    }
}
