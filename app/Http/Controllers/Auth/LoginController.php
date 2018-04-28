<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Set last login datetime, when user is logged in
        UserRepository::where('email', $user->email)->update(['last_login' => Carbon::now()]);    
    }

    /**
     * return login validation messages.
     *
     * @return array
     */
    protected function validationErrorMessages() {
        return [
            'email.required' => "L'adresse email est requise",
            'email.string' => "L'adresse email doit etre une chaine de caractères",
            'email.email' => "L'adresse email est invalide",
            'password.required' => 'Le mot de passe est requit',
            'password.string' => 'Le mot de passe doit être une chaine de caractères',
        ];
    }
}
