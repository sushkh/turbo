<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
       Schema::create('products', function (Blueprint $table) {
        $table->increments('id');
        $table->string('customer_code');
        $table->string('item');
        $table->string('quantity');
        
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
        Schema::drop('products');
    }
}
