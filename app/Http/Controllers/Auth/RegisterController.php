<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailJob;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:50'],
            // 'name_kana' => ['required', 'string', 'max:50', 'regex:/^(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6]|\xE3\x83\xBC|\x20|\xE3\x80\x80)+$/'],
            // 'company' => ['nullable', 'string', 'max:50'],
            // 'postcode' => ['required', 'numeric', 'digits:7'],
            // 'address' => ['required', 'string', 'max:100'],
            // 'phone' => ['required', 'numeric', 'digits_between:10,11'],
            // 'gender' => ['required'],
            // 'birthday' => ['required', 'string', 'max:100'],
            // 'nickname' => ['required', 'string', 'max:15'],
            // 'comment' => ['string', 'max:1000'],
            'email' => ['required', 'string', 'email', 'max:100',
                Rule::unique('users')->where(function ($query) use ($data) {
                    return $query->where('email', $data['email'])->whereIn('status', [0, 1,2])->where('deleted_at', NULL);
                }),
//                'unique:users,email,NULL,id,deleted_at,NULL,status,1:2',
                'confirmed'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $save_data = $data;
        $save_data['password'] = Hash::make($data['password']);
        return User::create($save_data);
    }

    public function registerTerms()
    {
        $title = '新規登録';
        return view('auth.register_terms')->with(compact('title'));
    }

    public function showRegistrationForm()
    {
        $data = session('sessRegister');
        $title = '新規登録';
        return view('auth.register')->with(compact('data', 'title'));
    }


    public function register(Request $request)
    {
        $this->validator($request->all());

        $data = $request->except('_token');

        $request->session()->start();
        $request->session()->put('sessRegister', $data);
        $request->session()->save();

        return redirect(route('register_confirm'));
    }

    public function showRegistrationConfirm()
    {
        $title = '新規登録（確認）';
        $data = session('sessRegister');
        return view('auth.register_confirm')->with(compact('title', 'data'));
    }

    public function registerConfirm(Request $request)
    {
        $data = session('sessRegister');

         if ($user = $this->create($data)) {

             event(new Registered($user));

             return redirect(route('register_complete'));
         } else {
             return redirect(route('register'));
         }
    }

    public function showRegistrationComplete()
    {
        $title = '新規登録（完成）';
        session(['sessRegister' => null]);
        return view('auth.register_complete')->with(compact('title'));
    }

    public function showRegistrationCompanyForm()
    {
        $data = session('sessCompanyRegister');
        $title = '新規登録（企業）';
        return view('auth.register_company')->with(compact('title'));
    }
}
