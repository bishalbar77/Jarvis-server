<?php

namespace App\Http\Controllers;
use App\VerificationType;
use Auth;
use Illuminate\Support\Facades\DB;
use Log;
use AWS;

use Illuminate\Http\Request;

class VerificationTypeController extends Controller
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
                'name' => "Verification Type"
            ]
        ]; 

        $filter = [];       

        if($request->status){
            $filter['status'] = $request->status == 'active' ? 'A' : 'I';
        }

        if($request->source){
            $filter['source'] = $request->source;
        }

        // print_r($filter);exit;

        $verificationtype = VerificationType::where($filter)->orderBy('id', 'desc')->get();

        return view('/verificationtype/verificationtype-list', [
            'breadcrumbs'   => $breadcrumbs,
            'verificationtype'  => $verificationtype,
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
                'link'=>"/verificationtype",
                'name'=>"Verification Types"
            ],
            [
                'name'=>"Create Verification Type"
            ]
        ];
        return view('/verificationtype/verificationtype-create', [
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
            'internal_name' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'source' => 'required',
        ]);

        $verification = new VerificationType;
        $verification->name = $request->name;
        $verification->internal_name = $request->internal_name;
        $verification->amount = $request->amount;
        if($request->hasFile('icon_url')) {
            $image          = $request->file('icon_url');
            $filename       = $image->getClientOriginalName();
            $tempid         = rand(10000,99999);
            $s3 = AWS::createClient('s3');
            $fileData = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'img/'.md5($tempid).$filename,
                'SourceFile'    => $request->file('icon_url'),
                'StorageClass'  => 'STANDARD',
                'ContentType'   => $request->file('icon_url')->getMimeType(),
                'ACL'           => 'public-read',
            ));
            if($fileData){
                $verification->icon_url = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
            }
        }
        $verification->description = $request->description;
        $verification->source = $request->source;
        $verification->status = $request->status;
        $verification->tat = $request->tat;
        $verification->order_type = $request->order_type;
        $verification->task_type = $request->task_type;
        $verification->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'VerificationTypeController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('verificationtype')->with('success', 'Verification Type created successfully!');
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
        $verificationtype = VerificationType::find($id);

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/verificationtype",
                'name'=>"Verification Types"
            ],
            [
                'name'=>"Edit Verification Type"
            ]
        ];
        
        return view('/verificationtype/verificationtype-edit', [
            'breadcrumbs' => $breadcrumbs,
            'verificationtype' => $verificationtype
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
            'internal_name' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'status' => 'required',
            'source' => 'required',
            'tat' => 'required'
        ]);

        $verificationtype = $old = VerificationType::find($id);
        $verificationtype->id = $id;
        $verificationtype->name = $request->name;
        $verificationtype->internal_name = $request->internal_name;
        $verificationtype->amount = $request->amount;
        $verificationtype->description = $request->description;        
        $verificationtype->status = $request->status;
        $verificationtype->source = $request->source;
        $verificationtype->tat = $request->tat;
        $verificationtype->order_type = $request->order_type;
        $verificationtype->task_type = $request->task_type;

        if($request->hasFile('icon_url')) {
            $image          = $request->file('icon_url');
            $filename       = $image->getClientOriginalName();
            $tempid         = rand(10000,99999);

            $s3 = AWS::createClient('s3');
            $fileData = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'img/'.md5($tempid).$filename,
                'SourceFile'    => $request->file('icon_url'),
                'StorageClass'  => 'STANDARD',
                'ContentType'   => $request->file('icon_url')->getMimeType(),
                'ACL'           => 'public-read',
            ));

            if($fileData){
                $verificationtype->icon_url = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
            }
        }
        $verificationtype->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'VerificationTypeController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => $old,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/verificationtype')->with('success', 'Verification Type details Updated successfully!');
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
        $verificationtype          = VerificationType::find($id);
        $verificationtype->id      = $id;
        $verificationtype->status  = $status;
        $verificationtype->save();

        $statusName = $status == '0' ? 'Disabled' : 'Enabled';

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'VerificationTypeController',
            'ACTION'        => 'CHANGE_STATUS',
            'OLD_DATA'      => $verificationtype,
            'NEW_DATA'      => $statusName,
        ]); 

        Log::critical($logData);

        return redirect('/verificationtype')->with('success', 'Verification Type status Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $verificationtype = VerificationType::find($id);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'VerificationTypeController',
            'ACTION'        => 'DELETED',
            'OLD_DATA'      => $verificationtype,
            'NEW_DATA'      => 'Delete',
        ]);

        Log::critical($logData);

        VerificationType::destroy($id);

        return redirect('/verificationtype')->with('success', 'Verification Type deleted successfully!');
    }
}
