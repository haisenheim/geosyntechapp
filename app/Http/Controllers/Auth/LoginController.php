<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
	//use Hash;

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
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout','locked','unlock']);

    }



    public function logout(){
        Auth::logout();
        return redirect('login');
    }

	// Added for the lockedscreen

	public function locked()
	{
		if(!session('lock-expires-at')){
			return redirect('/');
		}

		if(session('lock-expires-at') > now()){
			return redirect('/');
        }

		return view('auth.locked');
	}

	public function unlock(Request $request)
	{
		$check = Hash::check($request->input('password'), $request->user()->password);

		if(!$check){
			return redirect()->route('login.locked')->withErrors([
				'Le mot de passe ne correspond pas.'
			]);
		}
		//session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);
		session(['lock-expires-at' => now()->addMinutes(10)]);
		return redirect()->intended('formations');
	}
}
