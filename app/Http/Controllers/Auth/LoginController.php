<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\JarvisUser;
use Carbon\Carbon;
use App\User;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Login
    public function showLoginForm(){
      $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
      ];
      session(['link' => url()->previous()]);

      return view('/auth/login', [
          'pageConfigs' => $pageConfigs
      ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/auth-login');
    }

    public function process(Request $request)
    {
      $request->validate([
          'email' => 'required|string|email',
          'password' => 'required|string',
      ]);

      if($jarvis_user = JarvisUser::where(['email' => $request->email, 'status' => 'A'])->first()){

          if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('login')
              ->withInput($request->only('email', 'remember'))
              ->withErrors([
                'password' => 'password not matched',
              ]);
          }

          $user = User::find($jarvis_user->user_id);
          Auth::login($user);

          $user = Auth::user();
          $user->remember_token = Str::random(60);
          $user->save();

          if(session('link')){
            return redirect(session('link'));
          }
          return redirect('/');

      } else {

          return redirect('login')
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
              'email' => 'User Not Exists.',
            ]);
      }
    }
}
