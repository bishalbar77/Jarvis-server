<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use \Cache;
use App\ApiKey;

class APIController extends Controller
{

    public function users()
    {
        $users = User::select(['id', 'first_name', 'last_name', 'email', 'last_seen']);

        return Datatables::of($users)
            ->addColumn('actions', function ($users) {
                return \Carbon\Carbon::parse($users->last_seen)->diffForHumans();
            })
            ->addColumn('status', function ($users) 
            {
                if(Cache::has('user-is-online-' . $users->id)) 
                {
                return 'Online';
                }
                else
                {
                    return 'Offline';
                }                     
            })
            ->addColumn('action', function ($users) 
            {
                $info = '<a class="pl-2" href="/logActivity/'. $users->id.'" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="View">
                <i class="fa fa-info-circle text-info"></i>';
                $delete = '<a class="pl-3" href="/users/changestatus/'. $users->id .'" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="Delete">								
                <i class="fa fa-trash text-danger"></i>';
                return $info . $delete;
            })
            ->editColumn('id', '{{$id}}')
            ->setRowId('id')
            ->setRowData(['id' => 'test',])
            ->setRowAttr(['color' => 'red',])
            ->make(true);
    }

    public function index(Request $request)
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Api List"
            ]
        ];

        $apikeys = ApiKey::all();

        return view('apikeys.list', [
            'breadcrumbs' => $breadcrumbs,
            'apikeys' => $apikeys
        ]);
    }
}
