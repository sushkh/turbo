<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Dealer;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    	$admin = new Admin;
    	$admin->customer_code = "admin";
    	$admin->password = \Hash::make('disney');
    	$admin->level = "10";
    	$admin->save();

    	$admin = new Admin;
    	$admin->customer_code = "dealer";
    	$admin->password = \Hash::make('disney');
    	$admin->level = "5";
    	$admin->save();

    	$dealer = new Dealer;
    	$dealer->customer_code = "dealer";
    	$dealer->name = "dealer";
    	$dealer->contact = "8800607309";
    	$dealer->pump_name = "Dealer Pump";
    	$dealer->city = "Delhi";
    	$dealer->email = "dealer@gmail.com";
    	$dealer->save();

    }
}
