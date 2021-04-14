<?php

namespace App\Http\Controllers;
use Log;
use AWS;
use Auth;
use App\TaskTypeSeverity;
use App\SeverityMessage;
use App\TaskType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SeverityController extends Controller
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
                'name' => "Severty"
            ]
        ];

        $tasktypes = TaskType::get();

        $filter = [];       

        if($request->tasktype){
            $filter['task_type_severities.task_type_id'] = $request->tasktype;
        }

        $severity = TaskTypeSeverity::where($filter)
            ->select('task_type_severities.*', 'task_types.task_type', 'severity_messages.id as severity_id', 'severity_messages.severity_message')
            ->leftJoin('task_types', 'task_type_severities.task_type_id', '=', 'task_types.id')
            ->leftJoin('severity_messages', 'task_type_severities.severity_message_id', '=', 'severity_messages.id')
            ->orderBy('task_type_severities.id', 'desc')->get();

        return view('severity.list', [
            'breadcrumbs' => $breadcrumbs,
            'severity' => $severity,
            'tasktypes' => $tasktypes
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
                'link'=>"/severity",
                'name'=>"Severty"
            ],
            [
                'name'=>"Create Severty"
            ]
        ];

        $tasktypes = TaskType::get();
        $messeges = SeverityMessage::get();
        
        return view('severity.create', [
            'breadcrumbs' => $breadcrumbs,
            'tasktypes' => $tasktypes,
            'messeges' => $messeges
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

        if($request->severity_message_id == 'new'){
            $request->validate([
                'task_type_id' => 'required',
                'task_severity' => 'required',
                'severity_message_id' => 'required',
                'task_severity_message' => 'required'
            ]);
        } else {
            $request->validate([
                'task_type_id' => 'required',
                'task_severity' => 'required',
                'severity_message_id' => 'required'
            ]);            
        }

        if($request->severity_message_id == 'new'){
            
            $messeges = new SeverityMessage;
            $messeges->severity_message = $request->task_severity_message;
            $messeges->status = 'A';
            $messeges->save();
            
            $severity = new TaskTypeSeverity;
            $severity->task_type_id = $request->task_type_id;
            $severity->task_severity = $request->task_severity;
            $severity->severity_message_id = $messeges->id;
            $severity->save();
        } else {
            $severity = new TaskTypeSeverity;
            $severity->task_type_id = $request->task_type_id;
            $severity->task_severity = $request->task_severity;
            $severity->severity_message_id = $request->severity_message_id;
            $severity->save();
        }

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SeverityController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('severity')->with('success', 'Severty created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $severity = TaskTypeSeverity::find($id);
        $messege = SeverityMessage::find($severity->severity_message_id);
        $tasktypes = TaskType::get();
        $messeges = SeverityMessage::get();

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/severity",
                'name'=>"Severty"
            ],
            [
                'name'=>"Edit Severty"
            ]
        ];


        return view('/severity/edit', [
            'breadcrumbs' => $breadcrumbs,
            'severity' => $severity,
            'oldmessege' => $messege,
            'tasktypes' => $tasktypes,
            'messeges' => $messeges,
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
        if($request->severity_message_id == 'new'){
            $request->validate([
                'task_type_id' => 'required',
                'task_severity' => 'required',
                'severity_message_id' => 'required',
                'task_severity_message' => 'required'
            ]);
        } else {
            $request->validate([
                'task_type_id' => 'required',
                'task_severity' => 'required',
                'severity_message_id' => 'required'
            ]);            
        }

        if($request->severity_message_id == 'new'){
            
            $messeges = new SeverityMessage;
            $messeges->severity_message = $request->task_severity_message;
            $messeges->status = 'A';
            $messeges->save();
            
            $severity = $old = TaskTypeSeverity::find($id);
            $severity->task_type_id = $request->task_type_id;
            $severity->task_severity = $request->task_severity;
            $severity->severity_message_id = $messeges->id;
            $severity->save();
        } else {
            $severity = $old = TaskTypeSeverity::find($id);
            $severity->task_type_id = $request->task_type_id;
            $severity->task_severity = $request->task_severity;
            $severity->severity_message_id = $request->severity_message_id;
            $severity->save();
        }

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SeverityController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => $old,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/severity')->with('success', 'Severty details Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $severity = TaskTypeSeverity::find($id);
        $messege = SeverityMessage::find($severity->severity_message_id);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SeverityController',
            'ACTION'        => 'DELETED',
            'OLD_DATA'      => $severity.'--'.$messege,
            'NEW_DATA'      => 'Delete',
        ]);

        Log::critical($logData);

        SeverityMessage::destroy($severity->severity_message_id);
        TaskTypeSeverity::destroy($id);

        return redirect('/severity')->with('success', 'Severty deleted successfully!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function messages_index(Request $request)
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Severty Messages"
            ]
        ];

        $filter = [];       

        if($request->status){
            $filter['status'] = $request->status;
        }

        $severity = SeverityMessage::where($filter)->orderBy('id', 'desc')->get();

        return view('severity.message-list', [
            'breadcrumbs' => $breadcrumbs,
            'severity' => $severity
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function messages_create()
    {
        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/severity",
                'name'=>"Severty"
            ],
            [
                'name'=>"Create Severty"
            ]
        ];

        return view('severity.message-create', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function messages_store(Request $request)
    {
        $request->validate([
            'severity_message' => 'required'
        ]);

        $severity = new SeverityMessage;
        $severity->severity_message = $request->severity_message;
        $severity->status = $request->status;
        $severity->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SeverityController',
            'ACTION'        => 'MESSEGE_ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('severity/messages')->with('success', 'Severty Messages created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function messages_edit($id)
    {
        $severity = SeverityMessage::find($id);

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/severity/messages",
                'name'=>"Severty Messages"
            ],
            [
                'name'=>"Edit Severty Messages"
            ]
        ];

        return view('severity.message-edit', [
            'breadcrumbs' => $breadcrumbs,
            'severity' => $severity
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function messages_update(Request $request, $id)
    {
        $request->validate([
            'severity_message' => 'required'
        ]);

        $severity = $old = SeverityMessage::find($id);
        $severity->severity_message = $request->severity_message;
        $severity->status = $request->status;
        $severity->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SeverityController',
            'ACTION'        => 'MESSEGE_UPDATE',
            'OLD_DATA'      => $old,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/severity/messages')->with('success', 'Severty Messeges details Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function messages_destroy($id)
    {
        $severity = SeverityMessage::find($id);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SeverityController',
            'ACTION'        => 'MESSEGE_DELETED',
            'OLD_DATA'      => $severity,
            'NEW_DATA'      => 'Delete',
        ]);

        Log::critical($logData);

        SeverityMessage::destroy($id);

        return redirect('/severity/messages')->with('success', 'Severty deleted successfully!');
    }
}
