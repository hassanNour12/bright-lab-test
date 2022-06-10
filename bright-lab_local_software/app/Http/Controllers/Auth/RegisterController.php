<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try{
            $this->register_online_db($data['name'],$data['email'],$data['password']);
        }catch(Exception $e){
            dd($e);
        }
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    private function register_online_db(string $name,string $email,string $password) {
        $client = new Client(['verify' => false]); // I deactivated ssl verification
        $body = [
            'online_name' => $name,
            'online_email' => $email,
            'online_password' => $password,
        ];

        $response = $client->request(
            'POST',
            'http://192.168.1.5/bright-lab-test/online-soft/public/api/auth/register',
            [
                'headers' => [
                    'content-type' => 'application/json',
                    'accept' => 'application/ld+json'
                ],
                'body' => json_encode($body),
            ]
        );
        return $response;
    }

    // Register
    public function showRegistrationForm()
    {
        $pageConfigs = ['bodyCustomClass' => 'bg-full-screen-image'];

        return view('/auth/register', [
            'pageConfigs' => $pageConfigs
        ]);
    }
}
