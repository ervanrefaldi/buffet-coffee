<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(): RedirectResponse|View
    {
        return auth()->user()->hasVerifiedEmail()
            ? redirect()->intended('/')
            : view('auth.verify-email');
    }
}