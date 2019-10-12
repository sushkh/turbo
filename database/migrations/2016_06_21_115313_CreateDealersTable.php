<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('dealers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_code')->unique();
            $table->string('name');
            $table->string('contact');
            $table->string('pump_name');
            $table->string('city');
            $table->string('email');
            $table->string('petrol_price');
            $table->string('diesel_price');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('customer_code')->references('customer_code')->on('admin')->onDelete('cascade');

        });
   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dealers');
    }
}
