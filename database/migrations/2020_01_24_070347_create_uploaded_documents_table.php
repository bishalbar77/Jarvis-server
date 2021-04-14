<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadedDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploaded_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('filesName');
            $table->bigInteger('worker_id');
            $table->bigInteger('company_id');
            $table->bigInteger('docTypeId');
            $table->string('docNumber', 255);
            $table->enum('status', ['0','1'])->default('0');
            $table->string('orderId', 50);
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
        Schema::dropIfExists('uploaded_documents');
    }
}
