<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
       Schema::table('offers', function ($table) {
        $table->string('type');
         $table->string('quantity');
    });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function ($table) {
            $table->dropColumn('type');
            $table->dropColumn('quantity');


        });
    }
}
