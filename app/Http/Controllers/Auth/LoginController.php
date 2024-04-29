<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function authenticated()
    {
        if(Auth::user()->role_as == '1')
        {
            return redirect('admin/dashboard')->with('message','Welcome to dashboard');
        }
        else
        {
            return redirect('/')->with('status','Logged In Successfully');
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
