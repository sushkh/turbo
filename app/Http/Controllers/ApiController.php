<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use App\Admin;
use App\Dealer;
use App\Device;
use App\Reference;
use App\Customer;
use App\Transaction;
use App\Offer;
use DB;
class ApiController extends BaseController
{
	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;




/*
    RESPONSE CODES :::::
    110 : Data Valid ( Data is present in DB)
    100 :Device not found in db 
    101: Reference code already used
    111: Already registered
    001: aLREADY REGISTERED


*/


    public function check_device(){
    	$data = Input::all();
    	$device = Device::where('device_id',$data['device_id'])->first();
    	if($device){

    		return $device->device_pin;
    	}
    	else return '0';
    }


public function check_vehicle(){     //device id vehicle
	$data = Input::all();
	$cust = Customer::where('vehicle_number',$data['vehicle_number'])->first();
	if($cust){
		return '110';   //DEPICTS LOGIN
	}

	

	else return '100';  //DEPICTS REGISTRATION
}


public function register(){
	$data = Input::all();
	


	if(isset($data['reference_number'])){



		$ref = Reference::where('reference_number',$data['reference_number'])->first();

		if(isset($ref)&&(!$ref->flag)){


			$vehicle = Customer::where('vehicle_number',$data['vehicle_number'])->first();
			if(!$vehicle){


				$cust = new Customer();
				$cust->vehicle_number = $data['vehicle_number'];
				$cust->name = $data['name'];
				$cust->contact = $data['contact'];
				$cust->email = $data['email'];
				$dev=Device::where('device_id',$data['device_id'])->first();
				$cust->customer_code=$dev->customer_code;
				$cust->save(); 
				$ref->flag=1;
				$ref->save();
				return '110';
			}


			else{
				return '101';

			}

		}

		else{
			return '101';

		}
		


	}
	else
	{
		$vehicle = Customer::where('vehicle_number',$data['vehicle_number'])->first();
		if(!$vehicle){


			$cust = new Customer();
			$cust->vehicle_number = $data['vehicle_number'];
			$cust->name = $data['name'];
			$cust->contact = $data['contact'];
			$cust->email = $data['email'];
			$dev=Device::where('device_id',$data['device_id'])->first();
			$cust->customer_code=$dev->customer_code;
			$cust->save(); 

			return '110';
		}


		else{
			return '101';

		}
	}
}



/*public function fills(){

	$data = Input::all();
	$trans = new Transaction;
	$trans->device_id = $data['device_id'];
	$trans->vehicle_number = $data['vehicle_number'];
	$trans->volume = $data['fill_volume'];



	$customer = Customer::where('vehicle_number',$data['vehicle_number'])->first();
	$customer->total_volume += $data['fill_volume'];
	$customer->save();

	if($data['petrol']=='1')
		$trans->type = 'petrol';
	
	else if($data['petrol']=='0')
		$trans->type = 'diesel';
	else 
		$trans->type = 'speed';
	$f=-1;

	$ref = mt_rand(100000,1000000);
	while($f==-1)
	{
		if(Reference::where('reference_number',$ref)->first()){
			$ref = mt_rand(100000,1000000);
		}
		else 
			break;
	}
	$reference = new Reference;
	$reference->reference_number = $ref;
	$reference->flag =0;
	$reference->customer_id = $customer->id;
	$reference->save();
	$r_list = array();
	if(!$data['newuser_flag'])     // not new user
	{

		$device=Device::where('device_id',$data['device_id'])->first()->customer_code;
		$trans->customer_code=$device;
		$dealers = Dealer::where('customer_code',$trans->customer_code)->first();
		if($trans->type == 'petrol')
			$tp = $dealers->petrol_price;
		else if($trans->type=='diesel')
			$tp = $dealers->diesel_price;
		else
			$tp = $dealers->speed_price;
		$trans->save();
		$offer = Offer::where('customer_code',$device)->where('refill_type',$trans->type)->get();
		$ref = Reference::where('customer_id',$customer->id)->where('flag',1)->get();
		$count = count($ref);
		$t =  array();
		foreach($offer as $off )
		{
			if($off->discount_volume<=$customer->total_volume)
			{
				if($off->type=="percent")

					$t[]=array("id"=>$off->id,"percent"=>$off->discount_percent,"type"=>$off->type);
				
				else
					$t[]=array("id"=>$off->id,"percent"=>$off->discount_objects,"type"=>$off->type);
			}
		}

		if($count)
		{
			$refc = Offer::where('customer_code',$data['customer_code'])->where('refill_type','reference')->first();
			if($refc->type=="percent")
				$r_list=array("id"=>$refc->id,"percent"=>$refc->discount_perc,"type"=>$refc->type,"qty"=>$count);
			else
				$r_list=array("id"=>$refc->id,"percent"=>$refc->discount_objects,"type"=>$refc->type,"qty"=>$count);

		}
		$f = array("total_volume"=>$customer->total_volume,"discounts"=>$t,"transaction_id"=>$trans->id,'price'=>$tp,'list'=>$r_list);
		return response()->json($f);
	}
	else 
	{
		$device=Device::where('device_id',$data['device_id'])->first()->customer_code;
		$trans->customer_code=$device;
		$dealers = Dealer::where('customer_code',$trans->customer_code)->first();
		if($trans->type == 'petrol')
			$tp = $dealers->petrol_price;
		else if($trans->type=='diesel')
			$tp = $dealers->diesel_price;
		else
			$tp = $dealers->speed_price;
		$trans->save();
		$offer = Offer::where('customer_code',$device)->where('refill_type',$trans->type)->get();
		$ref = Reference::where('customer_id',$customer->id)->where('flag',1)->get();
		$count = count($ref);
		$t =  array();
		foreach($offer as $off)
		{
			if($off->discount_volume<=$customer->total_volume)
			{
				if($off->type=="percent")
					$t[]=array("id"=>$off->id,"percent"=>$off->discount_perc,"type"=>$off->type);
				else
					$t[]=array("id"=>$off->id,"percent"=>$off->discount_objects,"type"=>$off->type);
			}
		}
		$refc = Offer::where('customer_code',$device)->where('refill_type','ft')->first();
		if($refc)
		{
			if($refc->type=="percent")
				$r_list=array("id"=>$refc->id,"percent"=>$refc->discount_perc,"type"=>$refc->type,"qty"=>0);
			else
				$r_list=array("id"=>$refc->id,"percent"=>$refc->discount_objects,"type"=>$refc->type,"qty"=>0);
		}
		$f = array("total_volume"=>$customer->total_volume,"discounts"=>$t,"transaction_id"=>$trans->id,'price'=>$tp,'list'=>$r_list);
		return response()->json($f);
	}

}*/


public function fills(){

	$data = Input::all();
	$trans = new Transaction;
	$trans->device_id = $data['device_id'];
	$trans->vehicle_number = $data['vehicle_number'];
	$trans->volume = $data['fill_volume'];
	$device=Device::where('device_id',$data['device_id'])->first()->customer_code;




	$customer = Customer::where('vehicle_number',$data['vehicle_number'])->first();
	$customer->total_volume += $data['fill_volume'];
	$customer->volume += $data['fill_volume'];

	$customer->save();

	if($data['petrol']=='1')
		$trans->type = 'petrol';
	
	else if($data['petrol']=='0')
		$trans->type = 'diesel';
	else 
		$trans->type = 'speed';
	$f=-1;

	$ref = mt_rand(100000,1000000);
	$number=$ref;
	while($f==-1)
	{
		if(Reference::where('reference_number',$ref)->first()){
			$ref = mt_rand(100000,1000000);
		}
		else 
			break;
	}
	$reference = new Reference;
	$reference->reference_number = $ref;
	$reference->flag =0;
	$reference->customer_id = $customer->id;
	$reference->offer_id=Offer::where('customer_code',$device)->where('refill_type','reference')->first()->id;
	$reference->save();
	$r_list = array();
	if(!$data['newuser_flag'])     // not new user
	{

		$trans->customer_code=$device;
		$dealers = Dealer::where('customer_code',$trans->customer_code)->first();
		if($trans->type == 'petrol')
			$tp = $dealers->petrol_price;
		else if($trans->type=='diesel')
			$tp = $dealers->diesel_price;
		else
			$tp = $dealers->speed_price;
		$trans->save();
		$offer = Offer::where('customer_code',$device)->where('refill_type',$trans->type)->get();
		$ref = Reference::where('customer_id',$customer->id)->where('flag',1)->get();
		$count = count($ref);
		$t =  array();
		foreach($offer as $off ) 
		{
			if($off->discount_volume<=$customer->total_volume)
			{
				if(!strcmp($off->type,"percent"))

					$t[]=array("id"=>$off->id,"percent"=>$off->discount_percent,"message"=>"normal","type"=>"percent");
				else if(!strcmp($off->type,"rupees"))
					$t[]=array("id"=>$off->id,"percent"=>$off->discount_objects,"message"=>"normal","type"=>"rupees");
				else
					$t[]=array("id"=>$off->id,"percent"=>$off->quantity."*".$off->discount_objects,"message"=>"normal","type"=>"object");
			}
		}

		if($count)
		{
			foreach($ref as $r){
				$r->offer = Offer::where('id',$ref->offer_id)->first();


			/*$refc = Offer::where('customer_code',$data['customer_code'])->where('refill_type','reference')->first();	
			*/
			if(!strcmp($ref->offer->type,"percent"))
				$t[]=array("id"=>$ref->id,"percent"=>$count."*".$ref->offer->discount_perc,"message"=>"reference","type"=>"percent");
			else if(!strcmp($off->type,"rupees"))
				$t[]=array("id"=>$ref->id,"percent"=>$count."*".$ref->offer->discount_objects,"message"=>"reference","type"=>"rupees");
			else
				$t[]=array("id"=>$ref->id,"percent"=>$refc->quantity."*".$ref->offer->discount_objects,"message"=>"reference","type"=>"ojbect");
		}

	}
	$f = array("total_volume"=>$customer->total_volume,"discounts"=>$t,"transaction_id"=>$trans->id,'price'=>$tp,'reference_number'=>$number);
	return response()->json($f);
}
else 
{
	$device=Device::where('device_id',$data['device_id'])->first()->customer_code;
	$trans->customer_code=$device;
	$dealers = Dealer::where('customer_code',$trans->customer_code)->first();
	if(!strcmp($trans->type , 'petrol'))
		$tp = $dealers->petrol_price;
	else if(!strcmp($trans->type,'diesel'))
		$tp = $dealers->diesel_price;
	else
		$tp = $dealers->speed_price;
	$trans->save();
	$offer = Offer::where('customer_code',$device)->where('refill_type',$trans->type)->get();
	$ref = Reference::where('customer_id',$customer->id)->where('flag',1)->get();
	$count = count($ref);
	$t =  array();
	foreach($offer as $off )
	{
		if($off->discount_volume<=$customer->total_volume)
		{
			if(!strcmp($off->type,"percent"))

				$t[]=array("id"=>$off->id,"percent"=>$off->discount_percent,"message"=>"normal","type"=>"percent");
			else if(!strcmp($off->type,"rupees"))
				$t[]=array("id"=>$off->id,"percent"=>$off->discount_objects,"message"=>"normal","type"=>"rupees");
			else
				$t[]=array("id"=>$off->id,"percent"=>$off->quantity."*".$off->discount_objects,"message"=>"normal","type"=>"object");
		}
	}

	$refc = Offer::where('customer_code',$device)->where('refill_type','ft')->first();
	if($refc)
	{
		if(!strcmp($refc->type,"percent"))

			$t[]=array("id"=>$refc->id,"percent"=>$refc->discount_perc,"message"=>"ft","type"=>"percent");
		else if(!strcmp($refc->type,"rupees"))
			$t[]=array("id"=>$refc->id,"percent"=>$refc->discount_objects,"message"=>"ft","type"=>"rupees");
		else
			$t[]=array("id"=>$refc->id,"percent"=>$refc->quantity."*".$refc->discount_objects,"message"=>"ft","type"=>"object");
	}
	$f = array("total_volume"=>$customer->total_volume,"discounts"=>$t,"transaction_id"=>$trans->id,'price'=>$tp,'reference_number'=>$number);
	return response()->json($f);
}

}


public function calc(){
	$data = Input::all();
	$device=Device::where('device_id',$data['device_id'])->first()->customer_code;
	$dealer = Dealer::where('customer_code',$device)->first();
	dd($dealer);
	$trans = Transaction::where('id',$data['transaction_id'])->first();
	$customer = Customer::where('vehicle_number',$data['vehicle_number'])->first();
	if($data['petrol']==1)
	{

		$calc = $data['volume']*$dealer->petrol_price;
		$trans->rate = $dealer->petrol_price;
	}
	else if($data['petrol'] ==2)
	{
		$calc = $data['volume']*$dealer->diesel_price;
		$trans->rate = $dealer->diesel_price;
	}
	else{
		$calc = $data['volume']*$dealer->speed_price;
		$trans->rate = $dealer->speed_price;	
	}
	if($data['flag_discount']!=0)
	{
		if(!strcmp($data['message'],'reference')){
			$reference = Reference::where('id',$data['discount_id'])->first();
			$offer  = Offer::where('id',$reference->offer_id)->first();
			$reference->flag = 2;
			$reference->save();
			$trans->discount_type=$data['message'];
			//dd($offer);
			$customer->total_volume-=$offer->discount_volume;


			if(!strcmp($offer->type,"percent"))
			{
				$calc=$calc-($offer->discount_percent/100)*$calc;
				$trans->discount=$calc;

			}
			else if(!strcmp($offer->type,"rupees"))
			{
				$calc = $calc- $offer->discount_objects;
				$trans->discount=$calc;
			}
			else 
				$trans->discount=$offer->discount_objects."*".$offer->quantity;

			$trans->discount_type=$offer->type;
			$trans->total_cost=$calc;
			$trans->save();
			$customer->save();

			if($data['petrol']==1)
				return $dealer->petrol_price;
			else if($data['petrol']==0)
				return $dealer->diesel_price;
			else 
				return $dealer->speed_price;

		}

		$discount=Offer::where('id',$data['discount_id'])->first();
		if(count($discount)){
			$trans->discount_type=$data['message'];
			$customer->total_volume-=$discount->discount_volume;
			if(!strcmp($discount->type,"percent"))
			{
				$calc=$calc-($discount->discount_percent/100)*$calc;
				$trans->discount=$calc;
			}
			else if(!strcmp($discount->type,"rupees"))
			{
				$calc = $calc- $discount->discount_objects;
				$trans->discount=$calc;
			}
			else 
				$trans->discount=$discount->discount_objects."*".$discount->quantity;
		}
		$trans->discount_type=$discount->type;
	}

	$trans->total_cost=$calc;
	$trans->save();
	$customer->save();

	if($data['petrol']==1)
		return $dealer->petrol_price;
	else if($data['petrol']==0)
		return $dealer->diesel_price;
	else 
		return $dealer->speed_price;

}




/*
*****************
FOR ABHINAV******
*****************

*//*
public function check(){
	$data = Input::all();
	$user = DB::table('tester')->where('username',$data['username'])->first();
	if(count($user)){
		return "User Already Exists";
	}
	if($data['password'] == $data['repassword']){
		DB::table('tester')->insert(['name'=>$data['name'],'username'=>$data['username'],
			'password'=>$data['password'],'phone'=>$data['phone'],'email'=>$data['email']]);
		return 'Successfully Registered';
	}
	return 'Password Dont Match';
}
public function check2(){
	$data = Input::all();
	$user = DB::table('tester')->where('username',$data['username'])->first();
	if(count($user)){
		if($user->password == $data['password']){
			return "Login Successfully";
		}
		return "Incorrect Password";
	}
	return "Incorrect Username";
	
}*/
}
/*
public function check_vehicle(){     //device id vehicle
	$data = Input::all();
	if(Customer::where('vehicle_number',$data['vehicle_number'])->first()){
		return '110'   //DEPICTS LOGIN
	}

	return '100';  //DEPICTS REGISTRATION
}

public function register_user(){
	$data = Input::all();
	if(Device::where('device_id',$data['device_id'])->first()){
		$device = Device::where('device_id',$data['device_id'])->first();
		if($device->device_pin == $data['device_pin']){
			if($data['flag']=='1'){                                              //flag -> registration/login
				$cust = new Customer;
				$cust->vehicle_number = $data['vehicle_number'];
				$cust->name = $data['name'];
				$cust->contact = $data['contact'];
				$cust->email = $data['email'];
				$cust->save();


				$device = new Device;
				$device->device_pin = $data['device_pin'];
				$device->device_id = $data['device_id'];
				$device->save();



				$ref = Reference::where('reference_number',$data['reference_number'])->first();

				if($ref){
					return '101';   //DEPICTS rEF ID USED
				}
				else{
					$ref->flag=1;
					$ref->save();

					return '001';   //DEPICTS REGISTRATIOMN COMPLETED

				}




			}
		}


	}

}

public function input()





}





//input into db
vehivle no
device_id
total_volume


RESPONSE->JSON

totL_VOLUME++

DISCOUNT inFOKWEY VALUE



KEY IF AVAILED OR NOT AVAILEDD
IF AVAILED THEN GIVE DISCOUNT ID



//VEHICLE NU,MBER ,IMEI,DISCOUNT_ID ,flag_discount,total_volume


if(flag_discount=1)
	volume--
cost




response main present litre main amount
discount AVAILED


*/


