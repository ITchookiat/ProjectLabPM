<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
      $loginType = request()->input('username');
      $this->username = filter_var($loginType, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
      request()->merge([$this->username => $loginType]);

      $DatabaseType = request()->input('DB_type');
      $GetUser = request()->input('username');

      $Users = User::where('username', '=', $GetUser)->first();
      
      // กำหนดค่าให้กับ session
      // session(['type' => $DatabaseType]);

      // if ($DatabaseType == 2) {
      //   if ($Users->branch == 01 or $Users->branch == 03 or $Users->branch == 04 or $Users->branch == 05 or $Users->branch == 06 or $Users->branch == 07 or $Users->branch == 31) {
      //     dd('คุณไม่มีสิทธใช้งานในส่วนนี้');
      //   }
      // }

      return property_exists($this, 'username') ? $this->username : 'email';
    }
}
