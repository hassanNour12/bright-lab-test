<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use App\Models\Customers;
use App\Models\Toppings;
use App\Models\Orders;
use App\Models\Sync;

class SyncDataController extends Controller
{
    public function index()
    {
        return view('pages.sync.sync-index');
    }

    public function sync(Request $request)
    {
        try {
            // login user 
            $data = $this->login_to_online_software($request->email,$request->password);
            $data = json_decode($data);
            // user token for auth 
            $token = $data->access_token;
            // getting last time data was synced if it is the first time then it will user today's date and time else it will check sync table in the database
            $now = now();
            $last_sync = Sync::latest('id')->first();
            if(!is_null($last_sync)){
                $now=$last_sync->created_at;
            }
            // getting new orders
            $new_orders = Orders::all()->whereNull("synced_at");
            // getting updated order: it will check if updated_at timestamp >= last time data synced
            $updated_orders = Orders::all()->where('updated_at',">=",$now)->whereNotNull("synced_at");
            
            $new_orders_array = array();
            $updated_orders_array = array();
            foreach($new_orders as $o){
                $new_orders_array[] = $o;
            }
            foreach($updated_orders as $o){
                $updated_orders_array[] = $o;
            }
            // getting new customers
            $new_customers = Customers::all()->whereNull("synced_at");
            // getting updated customers: it will check if updated_at timestamp >= last time data synced
            $updated_customers = Customers::all()->where('updated_at',">=",$now)->whereNotNull("synced_at");
            
            $new_customers_array = array();
            $updated_customers_array = array();
            foreach($new_customers as $o){
                $new_customers_array[] = $o;
            }
            foreach($updated_customers as $o){
                $updated_customers_array[] = $o;
            }
            // getting new toppings 
            $new_toppings = Toppings::all()->whereNull("synced_at");
            // getting updated toppings : it will check if updated_at timestamp >= last time data synced
            $updated_toppings = Toppings::all()->where('updated_at',">=",$now)->whereNotNull("synced_at");
            
            $new_toppings_array = array();
            $updated_toppings_array = array();
            foreach($new_toppings as $o){
                $new_toppings_array[] = $o;
            }
            foreach($updated_toppings as $o){
                $updated_toppings_array[] = $o;
            }

            $client = new Client(['verify' => false]);
            $body = [
                'new_orders' => $new_orders_array,
                'updated_orders' => $updated_orders_array,
                'new_customers' => $new_customers_array,
                'updated_customers' => $updated_customers_array,
                'new_toppings' => $new_toppings_array,
                'updated_toppings' => $updated_toppings_array,
            ];
            // dd($body["updated_toppings"]);
            $response = $client->request(
                'POST',
                'http://192.168.1.5/bright-lab-test/online-soft/public/api/data/sync-data',
                [
                    'headers' => [
                        'Authorization' => "Bearer ".$token,
                        'content-type' => 'application/json',
                        'accept' => 'application/ld+json'
                    ],
                    'body' => json_encode($body),
                ]
            );
            $data = $response->getBody()->getContents();
            // After syncing successfully update synced_at attribute for all records 
            foreach($new_orders_array as $o){
                $record = Orders::find($o->id);
                $record->synced_at = now();
                $record->update();
            }
            foreach($updated_orders_array as $o){
                $record = Orders::find($o->id);
                $record->synced_at = now();
                $record->update();
            }

            foreach($new_customers_array as $o){
                $record = Customers::find($o->id);
                $record->synced_at = now();
                $record->update();
            }
            foreach($updated_customers_array as $o){
                $record = Customers::find($o->id);
                $record->synced_at = now();
                $record->update();
            }

            foreach($new_toppings_array as $o){
                $record = Toppings::find($o->id);
                $record->synced_at = now();
                $record->update();
            }
            foreach($updated_toppings_array as $o){
                $record = Toppings::find($o->id);
                $record->synced_at = now();
                $record->update();
            }
            // create new sync record
            $total_synced = count($new_orders_array) +count($updated_orders_array) +count($new_customers_array) +count($updated_customers_array) +count($new_toppings_array) +count($new_toppings_array);
            $sync = new Sync;
            $sync->data_synced_number = $total_synced;
            $sync->created_at = now();
            $sync->updated_at = now();
            $sync->save();
            // send email 
            return redirect('/send_email/'.$total_synced.'/'.now());
        } catch (RequestException $e){
            return redirect('sync')->with('failed',"Operation Failed");
            // dd($e);
        }
        
        

    }

    private function login_to_online_software(string $email,string $password)
    {
        try {
            $client = new Client(['verify' => false]);
            $body = [
                'email' => $email,
                'password' => $password,
            ];
    
            $response = $client->request(
                'POST',
                'http://192.168.1.5/bright-lab-test/online-soft/public/api/auth/login',
                [
                    'headers' => [
                        'content-type' => 'application/json',
                        'accept' => 'application/ld+json'
                    ],
                    'body' => json_encode($body),
                ]
            );
            $data = $response->getBody()->getContents();
            return $data;
        } catch(Exception $e) {
            return 0;
        }
        
    }
}
