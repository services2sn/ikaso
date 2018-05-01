<?php

namespace App\Http\Controllers\Auth\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Notifications\AccountCreated;
use Illuminate\Support\Facades\Crypt;

class ReturnActivationLink extends Controller
{
    /**
     * Show the application's sendActivationLink form
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm() 
    {
        return view('auth.account.email');
    }

    /**
     * Return the activation link if the user exists
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendActivationLink(Request $request) 
    {
        $this->validateEmail($request);
        $user = UserRepository::where('email', $request->only('email'))->first();
        return is_null($user) ? $this->sendActivationLinkFailedResponse($request) : $this->sendResetLinkResponse($user);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email'], $this->validationErrorMessages());
    }

    /**
     * return email validation messages.
     *
     * @return array
     */
    protected function validationErrorMessages() 
    {
        return [
            'email.required' => "L'adresse email est requise",
            'email.email' => "L'adresse email est invalide"
        ];
    }

    /**
     * Return to the sendActivationLink page with error message when the user email is not found
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendActivationLinkFailedResponse(Request $request)
    {
        return back()->withInput($request->only('email'))->withErrors(
            ['email' => "Aucun compte n'est associé à l'email que vous avez saisi"]
        );
    }

    /**
     * Return to the sendActivationLink page with success message
     *
     * @param  \App\Repositories\UserRepository  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($user)
    {
        $user->notify(new AccountCreated($user->activation_code, true));
        return back()->with('status', [
            'type'    => 'success',
            'message' => "Le lien d'activation de votre compte vous a été envoyé par mail."
        ]);
    }
}
