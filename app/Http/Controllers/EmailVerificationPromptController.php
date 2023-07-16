<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
use Laravel\Fortify\Fortify;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\VerifyEmailViewResponse
     */
    public function __invoke(Request $request)
    {
        dd('dump from my new controller');
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(Fortify::redirects('email-verification'))
            : app(VerifyEmailViewResponse::class);
    }
}
