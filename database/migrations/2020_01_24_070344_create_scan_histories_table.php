<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scan_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('empId');
            $table->bigInteger('docTypeId');
            $table->string('docNumber', 255);
            $table->string('latitude', 45);
            $table->string('longitude', 45);
            $table->string('ipAddress', 255);
            $table->longText('browserInfo');
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
        Schema::dropIfExists('scan_histories');
    }
}
