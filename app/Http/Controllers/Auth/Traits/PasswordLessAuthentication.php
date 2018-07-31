<?php

namespace App\Http\Controllers\Auth\Traits;

use App\LoginAttempt;
use App\Notifications\NewLoginAttempt;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait PasswordLessAuthentication
{
    use AuthenticatesUsers;

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $messages = [
            'exists' => trans('auth.exists'),
        ];

        $this->validate($request, [
            $this->username() => 'required|email|exists:users',
        ], $messages);
    }

    /**
     * Handle a login attempt request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function attempt(Request $request)
    {
        $this->validateLogin($request);

        if ($this->createLoginAttempt($request)) {
            return $this->sendAttemptResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login($token, Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($token, $request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param string $token
     * @param \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin($token, Request $request)
    {
        $user = LoginAttempt::userFromToken($token);

        return $this->guard()->login($user);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\LoginAttempt
     */
    protected function createLoginAttempt(Request $request)
    {
        $authorize = LoginAttempt::create([
            'email' => $request->input($this->username()),
            'token' => str_random(40) . time(),
        ]);

        $authorize->notify(new NewLoginAttempt($authorize));

        return $authorize;
    }

    /**
     * @param $request
     */
    public function sendAttemptResponse($request)
    {
        return \View::make('auth._link-sent');
    }
}
