<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Log;
use Auth;

class RoleController extends Controller
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
                'name' => "Roles List"
            ]
        ];

        $roles = Role::all();

        return view('roles.list', [
            'breadcrumbs' => $breadcrumbs,
            'roles'       => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/roles",
                'name'=>"Roles"
            ],
            [
                'name'=>"Create Role"
            ]
        ];
        return view('roles.create', [
            'breadcrumbs' => $breadcrumbs
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
        $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
        ]);

        $roles = new Role;
        $roles->name = $request->name;
        $roles->guard_name = $request->guard_name;
        $roles->save();

        $logData = json_encode([
            'BY'            => Auth::id(),
            'CONTROLLER'    => 'RoleController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('roles')->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::find($id);

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/roles",
                'name'=>"Roles"
            ],
            [
                'name'=>"Edit Role"
            ]
        ];
        
        return view('roles.edit', [
            'breadcrumbs' => $breadcrumbs,
            'roles'       => $roles
        ]);
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
        $request->validate([
            'name' => 'required',
            'guard_name' => 'required'
        ]);

        $role = $roleo = Role::find($id);
        $role->id = $id;
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $role->save();

        $logData = json_encode([
            'BY'            => Auth::id(),
            'CONTROLLER'    => 'RolesController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => $roleo,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/roles')->with('success', 'Role details Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        $logData = json_encode([
            'BY'            => Auth::id(),
            'CONTROLLER'    => 'RolesController',
            'ACTION'        => 'DELETED',
            'OLD_DATA'      => $role,
            'NEW_DATA'      => 'Delete',
        ]);

        Log::critical($logData);

        Role::destroy($id);

        return redirect('/roles')->with('success', 'Role deleted successfully!');
    }

    public function role_permissions($id)
    {
        $roles = Role::find($id);

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/roles",
                'name'=>"Roles"
            ],
            [
                'name'=>"Edit Role"
            ]
        ];
        return view('roles.permissions', [
            'breadcrumbs' => $breadcrumbs,
            'roles'       => $roles
        ]);
    }
}
