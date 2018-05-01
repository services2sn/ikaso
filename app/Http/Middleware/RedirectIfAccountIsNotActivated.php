<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAccountIsNotActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! Auth::user()->hasActivatedAccount()) 
        {
            Auth::logout();
            return redirect()->route('account.email')->with('status',  $this->getStatus());
        }
        return $next($request);
    }

    /**
     * Set the status message returned when the user's account is not activated
     *
     * @return array
     */
    private function getStatus() {
        return [
            'type'    => 'danger', 
            'message' => "Votre compte n'est été activé. Un lien d'activation vous a été envoyé lors de votre inscription."
        ];
    }
}
