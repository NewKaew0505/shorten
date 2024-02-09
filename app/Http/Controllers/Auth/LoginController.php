<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        return 'username';
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->get("username"))->first();

        if (empty($user)) {
            return redirect()->route('login')->withErrors(['username' => 'ไม่มี Username ที่ระบุ!!!']);
        } else {
            if (Hash::check($request->get('password'), $user->password)) {
                Auth::login($user);
                return redirect()->intended($this->redirectTo);
            } else {
                return redirect()->route('login')->withErrors(['password' => 'รหัสผ่านไม่ถูกต้อง!!!']);
            }
        }
    }
}
