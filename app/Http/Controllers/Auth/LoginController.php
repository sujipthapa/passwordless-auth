<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Traits;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    use Traits\PasswordLessAuth;

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
}
