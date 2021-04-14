<?php

namespace App\Http\Controllers;
use App\DocumentType;
use Auth;
use Illuminate\Support\Facades\DB;
use Log;

use Illuminate\Http\Request;

class DocumentTypeController extends Controller
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
                'name' => "Documents Type"
            ]
        ]; 

        $filter[] = '';       

        $filter = [];       

        if($request->status){
            $filter['status'] = $request->status == 'active' ? '1' : '0';
        }

        if($request->source){
            $filter['source'] = $request->source == 'B' ? 'B' : 'C';
        }

        $documents = DocumentType::where($filter)->orderBy('id', 'desc')->get();

        return view('/documents/documents-list', [
            'breadcrumbs' => $breadcrumbs,
            'documents'   => $documents,
            'filter'      => $filter
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
                'link'=>"/documents",
                'name'=>"Document Types"
            ],
            [
                'name'=>"Create DocumentType"
            ]
        ];
        return view('/documents/documents-create', [
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
            'source' => 'required',
            'status' => 'required'
        ]);

        $documentsData  = DocumentType::create($request->all());

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'DocumentTypeController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('documents')->with('success', 'Document Type created successfully!');
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
        $documents = DocumentType::find($id);

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/documents",
                'name'=>"Document Types"
            ],
            [
                'name'=>"Edit Document Type"
            ]
        ];
        
        return view('/documents/documents-edit', [
            'breadcrumbs'   => $breadcrumbs,
            'documents'     => $documents
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
            'status' => 'required',
            'source' => 'required'
        ]);

        $documents = $old   = DocumentType::find($id);
        $documents->id      = $id;
        $documents->name    = $request->name;
        $documents->source  = $request->source;
        $documents->status  = $request->status;
        $documents->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'DocumentTypeController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => $old,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/documents')->with('success', 'Document Type details Updated successfully!');
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
        $documents          = DocumentType::find($id);
        $documents->id      = $id;
        $documents->status  = $status;
        $documents->save();

        $statusName = $status == '0' ? 'Disabled' : 'Enabled';

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'DocumentTypeController',
            'ACTION'        => 'CHANGE_STATUS',
            'OLD_DATA'      => $documents,
            'NEW_DATA'      => $statusName,
        ]); 

        Log::critical($logData);

        return redirect('/documents')->with('success', 'DocumentTypestatus Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $documents = DocumentType::find($id);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'DocumentTypeController',
            'ACTION'        => 'DELETED',
            'OLD_DATA'      => $documents,
            'NEW_DATA'      => 'Delete',
        ]);

        Log::critical($logData);

        DocumentType::destroy($id);

        return redirect('/documents')->with('success', 'Document Type deleted successfully!');
    }
}
