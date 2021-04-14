<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GeoIP;
use DB;
use App\User;
use App\Session;
use LogActivity;
class LogActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $log = \LogActivity::logActivityId($id);
        return view('logs.show')->with(['log' => $log]);
    }

    public function changestatus($id)
    {
        $user = User::find($id);
        $user->is_active=!$user->is_active;
        if($user->save())
        {
  
            return redirect()->back()->with('disabled', 'User status have been changed');
        }
        else {
           
            return redirect(route('ajax'));
            
        }
    }

    public function session(Request $request)
    {
        $session = new Session();
        $session->session_expire = $request->session_expire;
        $session->save();
        \LogActivity::addToLog($session);
        return back();
    }
}
