<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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

    // /**
    //  * return reset password validation messages.
    //  *
    //  * @return array
    //  */
    // protected function validationErrorMessages() {
    //     return [
    //         'email.required' => "L'adresse email est requise",
    //         'email.string' => "L'adresse email doit etre une chaine de caractères",
    //         'email.email' => "L'adresse email est invalide",
    //         'password.required' => 'Le mot de passe est requit',
    //         'password.string' => 'Le mot de passe doit être une chaine de caractères',
    //     ];
    // }
}
