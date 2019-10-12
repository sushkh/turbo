<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
     Schema::create('reference', function (Blueprint $table) {
        $table->increments('id');
        $table->string('reference_number')->unique();
        $table->boolean('flag');
        $table->integer('customer_id')->unsigned()->length(10);
        $table->timestamps();
        
        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
     });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reference');
    }
}
