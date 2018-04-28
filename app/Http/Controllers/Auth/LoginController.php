<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * return login's validation messages.
     *
     * @return array
     */
    protected function validationMessages() {
        return [
            'email.required' => "L'adresse email est requise",
            'email.string' => "L'adresse email doit etre une chaine de caractères",
            'email.email' => "L'adresse email est invalide",
            'password.required' => 'Le mot de passe est requit',
            'password.string' => 'Le mot de passe doit être une chaine de caractères',
        ];
    }
}
