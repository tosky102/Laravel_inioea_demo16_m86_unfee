<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = RouteServiceProvider::MYPAGE;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
        view()->share(['title' => 'ログイン']);
    }
    protected function authenticated(Request $request, $user)
    {
        if ($user->status != 3) {
            return redirect()->route('mypage.basic_register');
        }
        return redirect($this->redirectTo);
    }

    protected function credentials(Request $request)
    {
        return array_merge(
            $request->only($this->username(), 'password'),
            ['status' => [1, 3, 4, 5]]
        );
    }

    


}
