<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('customers', function (Blueprint $table) {
        $table->increments('id');
        $table->string('vehicle_number')->unique();
        $table->string('customer_code');
        $table->string('name');
        $table->string('email');
        $table->string('contact');
        $table->string('total_volume')->default('0');
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
        Schema::drop('customers');
    }
}
