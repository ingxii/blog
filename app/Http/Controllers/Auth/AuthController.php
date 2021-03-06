<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $username = 'mobile';
    protected $redirectTo = '/user';
    protected $redirectAfterLogout = '/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'getLogout']]);
    }


    // public function authenticate(Request $request)
    // {
    //     $password = $request->get('password');
    //     $mobile = $request->get('mobile');
    //     $remember = $request->get('remember');

    //     $this->validate($request, [
    //         'mobile' => 'required|max:255',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt(['mobile' => $mobile, 'password' => $password], $remember)) {
    //         // 认证通过...
    //         // echo("<p>A</p>");
    //         return redirect()->intended('/');
    //     }
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => 'required|unique:users|min:6|max:32',
            // 'name' => 'required|max:255',
            // 'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'mobile' => $data['mobile'],
            // 'name' => $data['name'],
            // 'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
