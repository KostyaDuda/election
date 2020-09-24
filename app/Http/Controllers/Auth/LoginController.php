<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    public function login(Request $request)
    {
        // if($this->validateLogin($request))
        // {
        //     //return redirect()->route('home');
        //     dd("fuck");
        // }

        if(! auth()->attempt(request(['name','password'])))
        {
            return back();
        }
        return redirect()->route('home');
        
    }
    protected function validateLogin(Request $request)
    {
        if($this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]))
        return true;
    }

    public function username()
    {
           return 'name';
        }
        
    
    


}
