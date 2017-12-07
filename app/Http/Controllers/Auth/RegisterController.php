<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use GuzzleHttp\Client;

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
    protected $redirectTo = '/home';

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => 1,
        ]);
    }

    public function register(Request $request)
    {
        // $token = $request->input('g-recaptcha-response');
        // if ($token) 
        // {
        //     $client = new Client();
        //     $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
        //         'form_params' => array(
        //             'secret'    => '6LcY_jsUAAAAAN5MA3f8V1XSEm51qzX8GUlCyYg2',
        //             'response'  => $token
        //             )
        //         ]);
        //     $result = json_decode($response->getBody()->getContents());

        //     if($result)
        //         dd($result);
        // }
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $request->session()->flash('message', 'Record Created');
        return back();
    }

   
}
