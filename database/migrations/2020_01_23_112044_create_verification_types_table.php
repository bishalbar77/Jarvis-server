<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('verification_type', 255);
            $table->string('verification_amount', 10);
            $table->string('icon', 255);
            $table->enum('status', ['0','1'])->default('0');
            $table->enum('source', ['B','C'])->default('B');
            $table->enum('docRequired', ['0','1'])->default('0');
            $table->enum('isAddress', ['0','1'])->default('0');
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
        Schema::dropIfExists('verification_types');
    }
}
