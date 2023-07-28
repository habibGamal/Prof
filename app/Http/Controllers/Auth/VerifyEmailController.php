<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Traits\DetermineGuard;
class VerifyEmailController extends Controller
{
    use DetermineGuard;
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user($this->guard())->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user($this->guard())->markEmailAsVerified()) {
            event(new Verified($request->user($this->guard())));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
