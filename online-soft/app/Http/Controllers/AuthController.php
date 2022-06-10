<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Toppings;
use App\Models\Orders;
use App\Models\Customers;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        // $validator = Validator::make($request->all(), [
        //     'online_name' => 'required|string|between:2,100',
        //     'online_email' => 'required|string|email|max:100|unique:users',
        //     'online_password' => 'required|string|min:6',
        // ]);
        // if($validator->fails()){
        //     return response()->json($validator->errors()->toJson(), 400);
        // }
        $user = User::create(
                    [
                        'password' => bcrypt($request->online_password),
                        'name' => $request->online_name,
                        'email' => $request->online_email
                    ]
                );
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function add_data_to_database(Request $request)
    {
        foreach($request->new_orders as $order){
            $new_record = new Orders;
            $new_record->id = $order["id"];
            $new_record->customer_id = $order["customer_id"];
            $new_record->topping_id = $order["topping_id"];
            $new_record->quantity = $order["quantity"];
            $new_record->total = $order["total"];
            $new_record->created_at = $order["created_at"];
            $new_record->updated_at = $order["updated_at"];
            $new_record->deleted_at = $order["deleted_at"];
            $new_record->save();

        }
        foreach($request->updated_orders as $order){
            $update_record = Orders::find($order["id"]);
            $update_record->customer_id = $order["customer_id"];
            $update_record->topping_id = $order["topping_id"];
            $update_record->quantity = $order["quantity"];
            $update_record->total = $order["total"];
            $update_record->created_at = $order["created_at"];
            $update_record->updated_at = $order["updated_at"];
            $update_record->deleted_at = $order["deleted_at"];
            $update_record->update();
        }
        foreach($request->new_customers as $customer){
            $new_record = new Customers;
            $new_record->id = $customer["id"];
            $new_record->first_name = $customer["first_name"];
            $new_record->last_name = $customer["last_name"];
            $new_record->address = $customer["address"];
            $new_record->email = $customer["email"];
            $new_record->phone = $customer["phone"];
            $new_record->created_at = $customer["created_at"];
            $new_record->updated_at = $customer["updated_at"];
            $new_record->deleted_at = $customer["deleted_at"];
            $new_record->save();
        }
        foreach($request->updated_customers as $customer){
            $update_record = Customers::find($customer["id"]);
            $update_record->id = $customer["id"];
            $update_record->first_name = $customer["first_name"];
            $update_record->last_name = $customer["last_name"];
            $update_record->address = $customer["address"];
            $update_record->email = $customer["email"];
            $update_record->phone = $customer["phone"];
            $update_record->created_at = $customer["created_at"];
            $update_record->updated_at = $customer["updated_at"];
            $update_record->deleted_at = $customer["deleted_at"];
            $update_record->update();
        }
        foreach($request->new_toppings as $topping){
            $new_record = new Toppings;
            $new_record->topping_name = $topping["topping_name"];
            $new_record->topping_price = $topping["topping_price"];
            $new_record->created_at = $topping["created_at"];
            $new_record->updated_at = $topping["updated_at"];
            $new_record->deleted_at = $topping["deleted_at"];
            $new_record->save();
        }
        foreach($request->updated_toppings as $topping){
            $update_record = Toppings::find($topping["id"]);
            $update_record->topping_name = $topping["topping_name"];
            $update_record->topping_price = $topping["topping_price"];
            $update_record->created_at = $topping["created_at"];
            $update_record->updated_at = $topping["updated_at"];
            $update_record->deleted_at = $topping["deleted_at"];
            $update_record->update();
        }
        return response()->json([
            'message' => 'User successfully registered',
        ], 201);
    }
}
