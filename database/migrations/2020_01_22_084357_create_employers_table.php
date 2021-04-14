<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_code', 25);
            $table->string('rep_full_name', 50);
            $table->string('email', 150);
            $table->string('pass', 255);
            $table->string('address', 255);
            $table->string('photo', 255);
            $table->string('company_name', 255);
            $table->string('phone', 15);
            $table->string('otp', 6);
            $table->string('activationcode', 45);
            $table->enum('status', ['0', '1'])->default(0);
            $table->dateTime('registration_date');
            $table->ipAddress('registered_ip');
            $table->timestamp('last_active');
            $table->string('role', 45);
            $table->enum('mobile_verify', ['0', '1'])->default(0);
            $table->string('fb_id', 255)->nullable();
            $table->enum('source', ['B', 'C'])->default('B');
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
        Schema::dropIfExists('employers');
    }
}
