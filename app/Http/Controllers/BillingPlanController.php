<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VerificationType;
use App\BillingPlan;
use App\TaskType;
use App\Employer;
use Auth;
use Log;

class BillingPlanController extends Controller
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
                'name' => "Billing Plans"
            ]
        ];

        $tasktypes = TaskType::get();

        $filter = [];       

        if($request->tasktype){
            $filter['task_type_severities.task_type_id'] = $request->tasktype;
        }

        $billingplans = BillingPlan::where($filter)->orderBy('id', 'desc')->get();

        return view('billingplans.list', [
            'breadcrumbs' => $breadcrumbs,
            'billingplans' => $billingplans,
            'tasktypes' => $tasktypes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/billingplans",
                'name'=>"Billing Plans"
            ],
            [
                'name'=>"Billing Plans"
            ]
        ];

        $source = $request->source ? $request->source : 'B2B';
        $verificationtypes = VerificationType::where(array('status' => 'A', 'source' => $source))->get();
        
        return view('billingplans.create', [
            'breadcrumbs' => $breadcrumbs,
            'source' => $source,
            'verificationtypes' => $verificationtypes
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
            'code' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'billing_verification_tasks' => 'required'
        ]);

        $plans = new BillingPlan;
        $plans->code = $request->code;
        $plans->name = $request->name;
        $plans->description = $request->description;
        $plans->billing_verification_tasks = implode(',', $request->billing_verification_tasks);
        $plans->amount = $request->amount;
        $plans->status = $request->status;
        $plans->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'BillingPlanController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('billing-plans')->with('success', 'Billing Plan created successfully!');
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
    public function edit(Request $request, $id)
    {
        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/billingplans",
                'name'=>"Billing Plans"
            ],
            [
                'name'=>"Billing Plans Edit"
            ]
        ];

        $billingplans = BillingPlan::find($id);
        $source = $request->source ? $request->source : 'B2B';
        $verificationtypes = VerificationType::where(array('status' => 'A', 'source' => $source))->get();
        
        return view('billingplans.edit', [
            'breadcrumbs' => $breadcrumbs,
            'source' => $source,
            'verificationtypes' => $verificationtypes,
            'billingplans' => $billingplans
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
            'code' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'billing_verification_tasks' => 'required'
        ]);

        $plans = $old = BillingPlan::find($id);
        $plans->code = $request->code;
        $plans->name = $request->name;
        $plans->description = $request->description;
        $plans->billing_verification_tasks = implode(',', $request->billing_verification_tasks);
        $plans->amount = $request->amount;
        $plans->status = $request->status;
        $plans->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'BillingPlanController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => $old,
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('billing-plans')->with('success', 'Billing Plan created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $valid = Employer::select('id')->where('billing_plan_id', $id)->first();

        if(isset($valid) && !empty($valid->id)){
            
            return redirect('/billing-plans')->with('success', 'Billing Plan Used to Employer. So Unable to Delete!');
        
        } else {
            
            $plans = BillingPlan::find($id);

            $logData = json_encode([
                'BY'            => Auth::user()->id,
                'CONTROLLER'    => 'BillingPlanController',
                'ACTION'        => 'DELETED',
                'OLD_DATA'      => $plans,
                'NEW_DATA'      => 'Delete',
            ]);

            Log::critical($logData);

            BillingPlan::destroy($id);

            return redirect('/billing-plans')->with('success', 'Billing Plan deleted successfully!');
        }
    }
}
