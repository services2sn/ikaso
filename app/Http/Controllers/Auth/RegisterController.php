<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            'email' => 'bail|required|string|email|max:255|unique:users',
            'password' => 'bail|required|string|min:6|confirmed',
        ], $this->validationErrorMessages());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return UserRepository::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

        /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // Set last login datetime, when user is registered
        UserRepository::where('email', $user->email)->update(['last_login' => Carbon::now()]);    
    }

    /**
     * return register validation messages.
     *
     * @return array
     */
    protected function validationErrorMessages() {
        return [
            'email.required' => "L'adresse email est requise",
            'email.string' => "L'adresse email doit etre une chaine de caractères",
            'email.email' => "L'adresse email est invalide",
            'email.max' => "L'adresse email est tres longue. Elle ne doit pas dépasser 255 caractères",
            'email.unique' => "L'adresse email existe déjà",
            'password.required' => 'Le mot de passe est requit',
            'password.string' => 'Le mot de passe doit être une chaine de caractères',
            'password.min' => "Le mot de passe est très court. Il doit être composé d'au moins 6 caractères",
            'password.confirmed' => 'Le mot de passe est différent de sa confirmation'
        ];
    }
}
