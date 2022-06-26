<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\CarrinhoCompras;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/';

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
            'numero_mecanografico' => ['required', 'integer','unique:users'],
            'numero_telemovel' => ['required', 'integer','unique:users'],
            
        ],$messages = [
            'required'    => 'O :attribute é obrigatório',
            'string'    => 'O :attribute tem de ser texto',
            'email' => 'O :attribute tem de ser texto',
            'max'    => 'O :attribute tem de ser menor que :max.',
            'min'    => 'O :attribute tem que ter mais de :min caracteres.',
            'between'    => 'O :attribute tem de ser entre :min - :max de comprimento',
            'email' => 'O :attribute tem de ser um email',
            'integer'    => 'O :attribute tem de ser um numero',
            'unique'    => 'O :attribute já existe',
            
            
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
        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'grupo_id'=>2,
            'numero_mecanografico'=>$data['numero_mecanografico'],
            'numero_telemovel'=>$data['numero_telemovel']
        ]);
        $user->save();

        CarrinhoCompras::create([
            'user_id'=> $user->id,
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);


        return $user;
    }
}
