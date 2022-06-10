<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\Toppings;
use App\Models\Orders;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Orders::all();
        $arr_data = array();
        foreach($orders as $order){
            $data = array();
            $data["id"] = $order->id;
            $customer = Customers::find($order->customer_id);
            $data["customer_name"] = $customer->first_name." ".$customer->last_name;
            $topping = Toppings::find($order->topping_id);
            $data["topping_name"] = $topping->topping_name;
            $data["topping_qty"] = $order->quantity;
            $data["topping_total"] = $order->total;
            $last_status = "New";
            $date = $order->created_at;
            
            if(!is_null($order->deleted_at)) {
                $last_status = "Deleted";
                $date = $order->deleted_at;
            }
            elseif(is_null($order->synced_at)) {
                if($order->updated_at > $order->created_at){
                    $last_status = "Updated";
                    $date = $order->updated_at;
                }
                
            }elseif(!is_null($order->synced_at)) {
                if(($order->synced_at) >= ($order->updated_at)) {
                    $last_status = "Synced";
                    $date = $order->synced_at;
                }
                if(($order->synced_at) < ($order->updated_at)) {
                    $last_status = "Updated After Synced";
                    $date = $order->updated_at;
                }
            }
            $data["status"] = $last_status;
            $data["date"] = $date;
            $arr_data[]=$data;
        }
        return view('pages.orders.orders-index',["orders"=>$arr_data]);
    }

    public function add_new_order_view()
    {
        $customers = Customers::all()->whereNull('deleted_at');
        $toppings = Toppings::all()->whereNull('deleted_at');
        $last_order = Orders::latest('id')->first();
        $last_id = 1;
        if(!is_null($last_order)){
            $last_id=$last_order->id;
        }
        return view('pages.orders.orders-add',["customers"=>$customers,"toppings"=>$toppings,"last_id"=>$last_id]);
    }
    public function add_new_order(Request $request)
    {
        // dd($request);
        $data = $request->input();
        try{
            $topping = Toppings::find($data['topping_id']);
            $order = new Orders;
            $order->customer_id	 = $data['customer_id'];
            $order->topping_id = $data['topping_id'];
            $order->quantity = $data['topping_qty'];
            $order->total = $data['topping_qty'] * $topping->topping_price;
            $order->created_at = now();
            $order->updated_at = now();
            $order->save();
            return redirect('orders')->with('success',"Successfully Added");
        }
        catch(Exception $e){
            return redirect('add-new-order-view')->with('failed',"Operation Failed");
        }
    }

    public function view_order($order_id)
    {
        $order = Orders::find($order_id);
        $order_number = $order->id;
        $customer = Customers::find($order->customer_id);
        $customer_name = $customer->first_name." ".$customer->last_name;
        $customer_address = $customer->address;
        $customer_phone = $customer->phone;
        $topping = Toppings::find($order->topping_id);
        $topping_name = $topping->topping_name;
        $topping_price = $topping->topping_price;
        $topping_qty = $order->quantity;
        $topping_total = $order->total;

        return view('pages.orders.order-view',["order_number"=>$order_number,"customer_name"=>$customer_name,"customer_address"=>$customer_address,"customer_phone"=>$customer_phone,"topping_name"=>$topping_name,"topping_qty"=>$topping_qty,"topping_total"=>$topping_total,"topping_price"=>$topping_price]);

    }

    public function edit_order_view($order_id)
    {
        $customers = Customers::all()->whereNull('deleted_at');
        $toppings = Toppings::all()->whereNull('deleted_at');
        $order = Orders::find($order_id);
        $order_number = $order->id;
        $customer = Customers::find($order->customer_id);
        $customer_id = $order->customer_id;
        $customer_address = $customer->address;
        $customer_phone = $customer->phone;
        $topping = Toppings::find($order->topping_id);
        $topping_id = $order->topping_id;
        $topping_price = $topping->topping_price;
        $topping_qty = $order->quantity;
        $topping_total = $order->total;

        return view('pages.orders.order-edit',["customers"=>$customers,"toppings"=>$toppings,"order_number"=>$order_number,"customer_id"=>$customer_id,"customer_address"=>$customer_address,"customer_phone"=>$customer_phone,"topping_id"=>$topping_id,"topping_qty"=>$topping_qty,"topping_total"=>$topping_total,"topping_price"=>$topping_price]);

    }

    public function update_order(Request $request)
    {
        // dd($request);
        $data = $request->input();
        try{
            $topping = Toppings::find($data['topping_id']);
            $order = Orders::find($data["order_id"]);
            $order->customer_id	 = $data['customer_id'];
            $order->topping_id = $data['topping_id'];
            $order->quantity = $data['topping_qty'];
            $order->total = $data['topping_qty'] * $topping->topping_price;
            $order->updated_at = now();
            $order->update();
            return redirect('orders')->with('success',"Successfully Added");
        }
        catch(Exception $e){
            return redirect('edit-order/'.$order_id)->with('failed',"Operation Failed");
        }
    }

    public function delete_order($order_id)
    {
        try 
        {
            $order = Orders::find($order_id);
            $order->deleted_at = now();
            $order->updated_at = now();
            $order->update();
            return redirect('orders')->with('success',"Successfully Deleted");
        }catch(Exception $e){
            return redirect('orders')->with('failed',"Operation Failed");
        }
    }

    public function enable_order($order_id)
    {
        try 
        {
            $order = Orders::find($order_id);
            $order->deleted_at = null;
            $order->updated_at = now();
            $order->update();
            return redirect('orders')->with('success',"Successfully Retrieved");
        }catch(Exception $e){
            return redirect('orders')->with('failed',"Operation Failed");
        }
    }
}