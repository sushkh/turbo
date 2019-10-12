<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('devices', function (Blueprint $table) {
        $table->increments('id');
        $table->string('device_id')->unique();
        $table->string('device_pin');
        $table->string('customer_code');
        $table->foreign('customer_code')->references('customer_code')->on('admin')->onDelete('cascade');
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
        Schema::drop('devices');
    }
}
