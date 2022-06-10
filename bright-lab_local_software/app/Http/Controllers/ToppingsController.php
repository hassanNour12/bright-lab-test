<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Toppings;

class ToppingsController extends Controller
{
    public function index()
    {
        $toppings = Toppings::all();
        return view('pages.toppings.toppings-index',["toppings"=>$toppings]);
    }

    public function add_new_topping(Request $request)
    {
        $rules = [
			'top_name' => 'required|string|min:3|max:255',
			'top_price' => 'required|numeric',
		];
        $validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return redirect('toppings')
			->withInput()
			->withErrors($validator);
		}
        else{
            $data = $request->input();
			try{
				$topping = new Toppings;
                $topping->topping_name = $data['top_name'];
                $topping->topping_price = $data['top_price'];
                $topping->created_at = now();
                $topping->updated_at = now();
				$topping->save();
				return redirect('toppings')->with('success',"Successfully Added");
			}
			catch(Exception $e){
				return redirect('toppings')->with('failed',"Operation Failed");
			}
		}
    }

    public function edit_topping(Request $request)
    {
        try 
        {
            $rules = [
                'new_top_name' => 'required|string|min:3|max:255',
                'new_top_price' => 'required|numeric',
            ];
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                return response()->json(['status'=>'failed','msg'=>'Missing Data']);
            }
            $topping = Toppings::find($request->top_id);
            $topping->topping_name = $request->new_top_name;
            $topping->topping_price = $request->new_top_price;
            $topping->updated_at = now();
            $topping->update();
            return response()->json(['status'=>'success','msg'=>'Successfully Updated']);
        }catch(Exception $e){
            return response()->json(['status'=>'failed','msg'=>'Operation Failed']);
        }
    }

    public function delete_topping($topping_id)
    {
        try 
        {
            $topping = Toppings::find($topping_id);
            $topping->deleted_at = now();
            $topping->updated_at = now();
            $topping->update();
            return redirect('toppings')->with('success',"Successfully Deleted");
        }catch(Exception $e){
            return redirect('toppings')->with('failed',"Operation Failed");
        }
    }

    public function enable_topping($topping_id)
    {
        try 
        {
            $topping = Toppings::find($topping_id);
            $topping->deleted_at = null;
            $topping->updated_at = now();
            $topping->update();
            return redirect('toppings')->with('success',"Successfully Retrieved");
        }catch(Exception $e){
            return redirect('toppings')->with('failed',"Operation Failed");
        }
    }
}
