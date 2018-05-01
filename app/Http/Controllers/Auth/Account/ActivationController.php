<?php

namespace App\Http\Controllers\Auth\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    /**
     * Show the application's created account page
     *
     * @return \Illuminate\Http\Response
     */
    public function created() 
    {
        Auth::logout();
        return view('auth.account.created');
    }

    /**
     * Handle the account validation process
     *
     * @param  String  $activationCode
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function activate($activationCode) 
    {
        $user = UserRepository::where('activation_code', $activationCode)->first();
        return is_null($user) ? $this->sendAccountActivationFailledResponse() : $this->sendAccountActivationResponse();
    }

    /**
     * Send a failled response when an error occured during the account activation process
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    private function sendAccountActivationFailledResponse() 
    {
        return redirect('/login')->with('status', [
            'type' => 'danger',
            'message' => "Une erreur est survenue lors de l'activation de votre compte."
        ]);
    }

    /**
     * Send a success response when the account is activated
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    private function sendAccountActivationResponse($user) 
    {
        $user->activateAccount();
        return redirect('/login')->with('status', [
            'type' => 'success',
            'message' => 'Votre compte est activé, vous pouvez vous y connecter maintenant.'
        ]);
    }
}