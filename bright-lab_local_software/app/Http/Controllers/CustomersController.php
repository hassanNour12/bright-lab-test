<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;

class CustomersController extends Controller
{
    public function index()
    {
        return view('pages.customers.customers-index');
    }

    public function add_new_customer_view()
    {
        return view('pages.customers.customers-add');
    }

    public function add_new_customer_data(Request $request)
    {
        $rules = [
			'fname' => 'required|string|min:3|max:255',
			'lname' => 'required|string|min:3|max:255',
			'email' => 'required|string|email|max:255',
            'address' => 'required|string|min:3|max:255'
		];
        $validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return redirect('customer-add')
			->withInput()
			->withErrors($validator);
		}
        else{
            $data = $request->input();
			try{
				$customer = new Customers;
                $customer->first_name = $data['fname'];
                $customer->last_name = $data['lname'];
				$customer->address = $data['address'];
				$customer->email = $data['email'];
                $customer->phone = $data['phNumber'];
                $customer->created_at = now();
                $customer->updated_at = now();
				$customer->save();
				return redirect('customer-add')->with('success',"Successfully Added");
			}
			catch(Exception $e){
				return redirect('customer-add')->with('failed',"Operation Failed");
			}
		}
    }

    public function get_all_customers(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        // Total records
        $totalRecords = Customers::select('count(*) as allcount')->whereNull('deleted_at')->count();
        $totalRecordswithFilter = Customers::select('count(*) as allcount')
        ->where('first_name', 'like', '%' .$searchValue . '%')
        ->orWhere('last_name', 'like', '%' .$searchValue . '%')
        ->whereNull('deleted_at')
        ->count();

        // Fetch records
        $records = Customers::orderBy($columnName,$columnSortOrder)
            ->where('first_name', 'like', '%' .$searchValue . '%')
            ->orWhere('last_name', 'like', '%' .$searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();
        $sno = $start+1;
        foreach($records as $record){
            $id = $record->id;
            $fname = $record->first_name;
            $lname = $record->last_name;
            $email = $record->email;
            $reg_at = date("Y-m-d h:i:s",strtotime($record->created_at));
            if(is_null($record->deleted_at)){
                $action = 
                    "
                    <a href=".asset('view-customer/'.$id)."><i class='bx bx-show-alt'></i></a>
                    <a href=".asset('edit-customer/'.$id)."><i class='bx bx-edit-alt'></i></a>
                    ";
            }else{
                $action = "<a href=".asset('enable-customer/'.$id)." class='btn btn-info glow invoice-create' role='button' aria-pressed='true'>Enable</a>";
            }
            

            $data_arr[] = array(
                "ch1" => "",
                "ch2" => "",
                "id" => $id,
                "fname" => $fname,
                "lname" => $lname,
                "email" => $email,
                "reg_at" => $reg_at,
                "action" => $action
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ); 

        echo json_encode($response);
        exit;
    }

    public function get_customer_data($customer_id)
    {
        
        $customer = Customers::where('id',$customer_id)->first();
        return view('pages.customers.customers-view',["customer"=>$customer]);
    }

    public function edit_customer_view($customer_id)
    {
        $customer = Customers::where('id',$customer_id)->first();
        return view('pages.customers.customers-edit',["customer"=>$customer]);
    }

    public function edit_customer_data(Request $request)
    {
        try 
        {
            $customer = Customers::find($request->customer_id);
            $customer->first_name = $request->fname;
            $customer->last_name = $request->lname;
            $customer->email = $request->email;
            $customer->phone = $request->phNumber;
            $customer->address = $request->address;
            $customer->updated_at = now();
            $customer->update();
            return redirect('edit-customer/'.$request->customer_id)->with('success',"Successfully Editted");
        }catch(Exception $e){
            return redirect('edit-customer/'.$request->customer_id)->with('failed',"Operation Failed");
        }
        
    }
    
    public function disable_customer($customer_id)
    {
        try 
        {
            $customer = Customers::find($customer_id);
            $customer->deleted_at = now();
            $customer->updated_at = now();
            $customer->update();
            return redirect('customers')->with('success',"Successfully Deleted");
        }catch(Exception $e){
            return redirect('edit-customer/'.$customer_id)->with('failed',"Operation Failed");
        }
        
    }

    public function enable_customer($customer_id)
    {
        try 
        {
            $customer = Customers::find($customer_id);
            $customer->deleted_at = null;
            $customer->updated_at = now();
            $customer->update();
            return redirect('customers')->with('success',"Successfully Retrieved");
        }catch(Exception $e){
            return redirect('edit-customer/'.$customer_id)->with('failed',"Operation Failed");
        }
        
    }
}
