<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use View;
use Illuminate\Support\Facades\Input;
use Redirect;
use Validator;
use Auth;
use App\Admin;
use App\Dealer;
use App\Offer;
use DB;
use App\Device;
use Session;
use App\Customer;
use App\Product;
use App\Transaction;
class DealerController extends BaseController
{
	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
	public function __construct()
	{
		$this->middleware('auth');
	}
	public static function dealers(){
		if(Auth::user() -> level <= 5){
			$action = "Dashboard";
			$name = Dealer::where('customer_code',Auth::user()->customer_code)->first()->name;
			$dealer =Dealer::where('customer_code',Auth::user()->customer_code)->first();
			$devices=Device::where('customer_code',Auth::user()->customer_code)->get()->pluck('device_id');
			$cust = count(Customer::where('customer_code',Auth::user()->customer_code)->get());
			$trans = Transaction::where('customer_code',Auth::user()->customer_code)->get()->pluck('volume');
			$cost = Transaction::where('customer_code',Auth::user()->customer_code)->get()->pluck('total_cost');
			$transaction = Transaction::where('customer_code',Auth::user()->customer_code)->orderBy('created_at', 'desc')->get();
			$cust = Customer::where('customer_code',Auth::user()->customer_code)->get();
			$names =  Auth::user()->customer_code;

			$transaction_chart = DB::select(DB::raw("SELECT SUM(volume) as volume,SUM(total_cost) as cost,type,CAST(created_at as DATE) as date  FROM `transaction` where `customer_code` = '$names' GROUP BY type,CAST(created_at as DATE)"));
			$diesel_graph = [];
			$petrol_graph = [];
			


			foreach ($transaction_chart as $tr){
				if($tr->type == 'petrol'){
					$petrol_graph[] = $tr;
				}
				else if($tr->type == 'diesel'){
					$diesel_graph[] = $tr;

				}

			}

			//dd($transaction_chart);
		//dd($petrol_graph);
			//dd($diesel_graph);
		/*	$i = 30;
		dd(date('Y-m-d',strtotime("-".$i." days")));
*/
		$total=0;
		foreach($trans as $t)
		{
			$total = $total +$t;

		}
		$income=0;
		foreach($cost as $c)
		{
			$income =$income + $c;
		}

		$counter=0;
		foreach($devices as $d)
		{
			$counter++;
		}

		foreach ($transaction as $transac) {
			$transac->customer = Customer::where('vehicle_number',$transac->vehicle_number)->first()->name;
			$transac->customer_id = Customer::where('vehicle_number',$transac->vehicle_number)->first()->id;

		}

		return View::make('dashboard_dealer', compact('action','name','dealer','counter','cust','total' ,'income','transaction','petrol_graph','diesel_graph'));
	}
	else{
		return Redirect::route('home');
	}
}
public function devices(){
	if(Auth::user()->level <= 5){
		$action = "Devices";
		$devices = Device::where('customer_code',Auth::user()->customer_code)->get();
		$name = Dealer::where('customer_code',Auth::user()->customer_code)->first()->name;

		return View::make('devices',compact('action','devices','name'));
	}
	else{
		return Redirect::route('home');

	}
}
public function add_device(){
	if(Auth::user()->level <= 5){
		$data = Input::all();
		$rules=array(
			'device_id' => 'required',
			'device_pin' => 'required',
			);
		$validator = Validator::make($data, $rules);
		if($validator->fails()){

			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else {
			if(Device::where('device_id',$data['device_id'])->first()){
				return Redirect::route('devices')->with('failure','Device Already Exists');

			}
			$admin = new Device;
			$admin->customer_code = Auth::user()->customer_code;
			$admin->device_id = $data['device_id'];
			$admin->device_pin = $data['device_pin'];
			$admin->save();

			return Redirect::route('devices')->with('success','Device Successfully Added');
		}

	}
}

public function delete_device($id){
	if(Auth::user()->level <= 5 && (Auth::user()->customer_code == Device::where('device_id',$id)->first()->customer_code)){
		$device = Device::where('device_id',$id)->first();
		if($device->delete()){
			return Redirect::route('devices')->with('success','Device Successfully Deleted');
		}
		else{
			return Redirect::route('devices')->with('failure','An Error Occured While Deleting Device!!! Please Try Again!!!');
		}
	}
	else{
		return Redirect::route('devices')->with('failure','Access Denied');
	}
}

public function offers(){
	if(Auth::user()->level <= 5){
		$action = "Offers";
		$offers = Offer::where('customer_code',Auth::user()->customer_code)->get();
		$name = Dealer::where('customer_code',Auth::user()->customer_code)->first()->name;
		$items = Product::where('customer_code',Auth::user()->customer_code)->get();

		return View::make('offers',compact('action','offers','name','items'));
	}
	else{
		return Redirect::route('home');

	}
}

public function add_offer(){
	if(Auth::user()->level <= 5){
		$data = Input::all();
		$rules=array(
			'discount_percent' => 'required',
			'discount_volume' => 'required',
			'refill_type' => 'required'
			);
		$validator = Validator::make($data, $rules);
		if($validator->fails()){

			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else {
			if(Offer::where('discount_percent',$data['discount_percent'])->
				where('discount_volume',$data['discount_volume'])->first()){
				return Redirect::route('offers')->with('failure','Offer Already Exists');
		}
		$offer = new Offer;
		$offer->refill_type = $data['refill_type'];
		$offer->type = $data['type'];
		$offer->customer_code = Auth::user()->customer_code;
		$offer->discount_volume = $data['discount_volume'];
		
		if($data['type']=="rupees")
		{
			$offer->discount_objects = $data['discount_rupees'];
			$offer->quantity = 0;
			
		}
		else if($data['type']=="percent")
		{
			$offer->discount_percent = $data['discount_percent'];
			$offer->quantity = 0;
		}
		
		else
		{
			$offer->discount_objects = Product::where('id',$data['item_list'])->first()->item;
			$offer->quantity = $data['quantity'];

		}
		$offer->save();
		return Redirect::route('offers')->with('success','Offer Successfully Added');
	}

}
}

public function delete_offer($id){
	if(Auth::user()->level <= 5 && (Auth::user()->customer_code == Offer::where('id',$id)->first()->customer_code)){
		$offer = Offer::where('id',$id)->first();
		if($offer->delete()){
			return Redirect::route('offers')->with('success','Offer Successfully Deleted');
		}
		else{
			return Redirect::route('offers')->with('failure','An Error Occured While Deleting Offer!!! Please Try Again!!!');
		}
	}
	else{
		return Redirect::route('offers')->with('failure','Access Denied');
	}

	
}
public function save_settings(){
	$data = Input::all();
	$dealer = Dealer::where('customer_code',Auth::user()->customer_code)->first();
	$dealer->petrol_price = $data['petrol_price'];
	$dealer->diesel_price = $data['diesel_price'];
	$dealer->speed_price = $data['speed_price'];
	Session::put('petrol_price',$data['petrol_price']);
	Session::put('speed_price',$data['speed_price']);

	Session::put('diesel_price',$data['diesel_price']);
	$dealer->save();
	Session::forget('check');
	return Redirect::route('dashboard')->with('success','Settings Successfully Saved');
}

public function items(){
	if(Auth::user()->level <= 5){
		$action = "Items";
		$items = Product::where('customer_code',Auth::user()->customer_code)->get();
		$name = Dealer::where('customer_code',Auth::user()->customer_code)->first()->name;

		return View::make('items',compact('action','items','name'));
	}
	else{
		return Redirect::route('home');

	}
}

public function add_item(){
	if(Auth::user()->level <= 5){
		$data = Input::all();
		$rules=array(
			'item' => 'required',
			'quantity' => 'required'
			);
		$validator = Validator::make($data, $rules);
		if($validator->fails()){

			return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else {
			if(Product::where('item',$data['item'])->
				where('quantity',$data['quantity'])->first()){
				return Redirect::route('items')->with('failure','Item Already Exists');
		}
		$item = new Product;
		$item->item = $data['item'];
		$item->customer_code = Auth::user()->customer_code;
		$item->quantity = $data['quantity'];
		$item->save();
		return Redirect::route('items')->with('success','Item Successfully Added');
	}

}
}
public function delete_item($id){
	if(Auth::user()->level <= 5 && (Auth::user()->customer_code == Product::where('id',$id)->first()->customer_code)){
		$item = Product::where('id',$id)->first();
		if($item->delete()){
			return Redirect::route('items')->with('success','Item Successfully Deleted');
		}
		else{
			return Redirect::route('items')->with('failure','An Error Occured While Deleting Item!!! Please Try Again!!!');
		}
	}
	else{
		return Redirect::route('items')->with('failure','Access Denied');
	}

	
}

public function item_list(){
	$data=Input::all();
	$qty = Product::where('customer_code',Auth::user()->customer_code)->where('id',$data['item_id'])->first()->quantity;

	if($qty){
		return $qty;
	}
	return 'error';
}
public function customers($id = null){
	if(Auth::user()->level <= 5){
		$action = "Customer";
		$name = Dealer::where('customer_code',Auth::user()->customer_code)->first()->name;
		if($id){
			$customer = Customer::where('customer_code',Auth::user()->customer_code)->where('id',$id)->first();
			if($customer){
				$transactions = Transaction::where('customer_code',Auth::user()->customer_code)->where('vehicle_number',$customer->vehicle_number)->get();
				$arr = [$customer,$transactions];
			//return response()->json($arr);
				return View::make('customer',compact('transactions','customer','action','name'));
			}
			else{
				return Redirect::route('dashboard')->with('failure','Access Denied');
			}
		}
		else{
			return Redirect::route('dashboard')->with('failure','Invalid Customer!!!');
		}
	}
	else{
		$action = "Customer";
		$name = Auth::user()->customer_code;
		if($id){
			$customer = Customer::where('id',$id)->first();
			if($customer){
				$transactions = Transaction::where('vehicle_number',$customer->vehicle_number)->get();
			//$arr = [$customer,$transactions];
			//return response()->json($arr);
				return View::make('customer',compact('transactions','customer','action','name'));
			}
			else{
				return Redirect::route('dashboard')->with('failure','Invalid Customer!!!');
			}
		}
		else{
			return Redirect::route('dashboard')->with('failure','Invalid Customer!!!');
		}

	}

}
public function customerprint($id = null){
	if(Auth::user()->level <= 5){
		$action = "Print";
		$name = Dealer::where('customer_code',Auth::user()->customer_code)->first()->name;
		if($id){
			$customer = Customer::where('customer_code',Auth::user()->customer_code)->where('id',$id)->first();
			if($customer){
				$transactions = Transaction::where('customer_code',Auth::user()->customer_code)->where('vehicle_number',$customer->vehicle_number)->get();
			//$arr = [$customer,$transactions];
			//return response()->json($arr);
				return View::make('customerprint',compact('transactions','customer','action','name'));
			}
			else{
				return Redirect::route('dashboard')->with('failure','Access Denied');
			}
		}
		else{
			return Redirect::route('dashboard')->with('failure','Invalid Customer!!!');
		}
	}
	else{
		$action = "Print";
		if($id){
			$customer = Customer::where('id',$id)->first();
			if($customer){
				$transactions = Transaction::where('vehicle_number',$customer->vehicle_number)->get();
				return View::make('customerprint',compact('transactions','customer','action','name'));
			}
			else{
				return Redirect::route('dashboard')->with('failure','Access Denied');
			}
		}
		else{
			return Redirect::route('dashboard')->with('failure','Invalid Customer!!!');
		}
	}
}
}
