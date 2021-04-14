<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LogActivity;
use App\Session;
use App\User;
use GeoIP;
use DB;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "User Activity Logs"
            ]
        ];  

        $users = User::select(['id', 'first_name', 'last_name', 'email', 'last_seen'])->paginate(10);

        return view('activity.index', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allactivity()
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "All Activity Logs"
            ]
        ];  

        $users = LogActivity::logActivityLists();

        return view('activity.allActivity', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::find($id);
        $logs = \LogActivity::logActivityLists();
        return view('logs.index',compact('logs'))->with([
            'users' => $users,
        ]);
    }

    public function details($id)
    {
        $log = \LogActivity::logActivityId($id);
        return view('logs.show')->with(['log' => $log]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
