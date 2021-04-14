<?php

namespace App\Http\Controllers;
use App\EmployeeType;
use Auth;
use Illuminate\Support\Facades\DB;
use Log;

use Illuminate\Http\Request;

class EmployeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Employee Type"
            ]
        ];        

        if($request->status){
            $filter = [
                'status' => $request->status == 'active' ? '1' : '0'
            ];
        } else {
            $filter = [];
        }

        $employeetype = EmployeeType::where($filter)->orderBy('id', 'desc')->get();

        return view('/employeetype/employeetype-list', [
            'breadcrumbs'   => $breadcrumbs,
            'employeetype'  => $employeetype,
            'filter'        => $filter
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
                'link'=>"/employeetype",
                'name'=>"Employee Types"
            ],
            [
                'name'=>"Create Employee Type"
            ]
        ];
        return view('/employeetype/employeetype-create', [
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
            'type'          => 'required',
            'description'   => 'required',
            'status'            => 'required',
            'source'            => 'required'
        ]);

        $data               = $request->all();
        $employeetypeData   = EmployeeType::create($data);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployeeTypeController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('employeetype')->with('success', 'Employee Type created successfully!');
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
        $employeetype = EmployeeType::find($id);

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/employeetype",
                'name'=>"Employee Types"
            ],
            [
                'name'=>"Edit Employee Type"
            ]
        ];
        
        return view('/employeetype/employeetype-edit', [
            'breadcrumbs'   => $breadcrumbs,
            'employeetype'     => $employeetype
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
            'type'          => 'required',
            'description'   => 'required',
            'status'            => 'required',
            'source'            => 'required'
        ]);

        $employeetype = $old           = EmployeeType::find($id);
        $employeetype->id              = $id;
        $employeetype->type        = $request->type;
        $employeetype->description = $request->description;
        $employeetype->status          = $request->status;
        $employeetype->source          = $request->source;
        $employeetype->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployeeTypeController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => $old,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/employeetype')->with('success', 'Employee Type details Updated successfully!');
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
        $employeetype          = EmployeeType::find($id);
        $employeetype->id      = $id;
        $employeetype->status  = $status;
        $employeetype->save();

        $statusName = $status == '0' ? 'Disabled' : 'Enabled';

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployeeTypeController',
            'ACTION'        => 'CHANGE_STATUS',
            'OLD_DATA'      => $employeetype,
            'NEW_DATA'      => $statusName,
        ]); 

        Log::critical($logData);

        return redirect('/employeetype')->with('success', 'EmployeeTypestatus Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employeetype = EmployeeType::find($id);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployeeTypeController',
            'ACTION'        => 'DELETED',
            'OLD_DATA'      => $employeetype,
            'NEW_DATA'      => 'Delete',
        ]);

        Log::critical($logData);

        EmployeeType::destroy($id);

        return redirect('/employeetype')->with('success', 'Employee Type deleted successfully!');
    }
}
