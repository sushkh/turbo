<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
        $table->increments('id');
        $table->string('customer_code');
        $table->string('refill_type'); //DIESEL OR PETROL OR SPEED OR FIRST TIMERS
        $table->string('discount_percent');
        $table->string('discount_volume');
        $table->timestamps();
        $table->foreign('customer_code')->references('customer_code')->on('dealers')->onDelete('cascade');
     });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('offers');
    }
}
