<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\PaymentHistory;
use App\OrderHistory;
use App\Employee;
use App\Employer;
use App\UploadedDocument;
use App\VerificationType;
use App\VerificationFields;
use App\AntecedentsField;
use App\ActionSummary;
use App\Escalation;
use App\Insuff;
use App\TaskComment;
use App\UserNotification;
use App\Address;
use App\CompanyNotifications;
use DB;
use AWS;
use PDF;
use OCR;
use OneSignal;

class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->perpage)){
            $perpage = $request->perpage;
        } else {
            $perpage = 10;
        }

        $s      = '';
        $source = '';
        $filter = array();

        if(isset($request->s)){
            $s = $request->s;

            $sArr = explode('-', $s);

            if(isset($sArr[0])){
                $filter['employers.emp_code'] = $sArr[0];
            }

            if(isset($sArr[1])){
                $filter['payment_histories.temp_id'] = $sArr[1];
            }
        }

        if(isset($request->status)){
            $filter['additional_amount_status'] = $request->status == 'active' ? '1' : '0';
        }

        if($request->source){
            $source = $request->source;
            $filter['employers.source'] = $request->source;
        }

        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Orders List"
            ]
        ];

        $orders = DB::table('payment_histories')
            ->leftJoin('employers', 'payment_histories.company_id', '=', 'employers.id')
            ->leftJoin('employees', 'payment_histories.worker_id', '=', 'employees.id')
            ->leftJoin('order_histories', 'payment_histories.temp_id', '=', 'order_histories.order_id')
            ->select('payment_histories.*', 'employers.emp_code', 'employers.company_name', 'employers.source', 'employees.first_name', 'employees.middle_name', 'employees.last_name', DB::raw('MAX(order_histories.tat) as maxTat'), DB::raw('MIN(order_histories.task_status) as maxStatus'))
            ->where($filter)
            ->groupBy('payment_histories.id')
            ->orderBy('payment_histories.id', 'desc')
            ->paginate($perpage);

        return view('/orders/orders-list', [
            'breadcrumbs'   => $breadcrumbs,
            'orders'        => $orders,
            'filter'        => $filter,
            'perpage'       => $perpage,
            's'             => $s,
            'source'        => $source,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $source             = $request->source ? $request->source : 'B';
        $employers          = Employer::where(array('status' => '1', 'source' => $source))->get();
        $employees          = Employee::where(array('source' => $source))->get();
        $verificationtypes  = VerificationType::where(array('status' => '1', 'source' => $source))->get();

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/orders",
                'name'=>"Orders List"
            ],
            [
                'name'=>"Create Order"
            ]
        ];
        return view('/orders/orders-create', [
            'breadcrumbs'       => $breadcrumbs,
            'employers'         => $employers,
            'employees'         => $employees,
            'verificationtypes' => $verificationtypes,
            'source'            => $source,
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
            'source'      => 'required',
            'company_id'  => 'required',
            'worker_id'   => 'required',
        ]);

        $order_id    = rand(1000000,9999999);
        $totalAmount = array();

        if(!empty($request->varifications)){
            foreach ($request->varifications as $key => $varification) {

                $verificationtypes  = VerificationType::where('id', $varification)->first();

                $orders = [
                    'task_id'               => $order_id + ($key + 1),
                    'order_id'              => $order_id,
                    'worker_id'             => $request->worker_id,
                    'company_id'            => $request->company_id,
                    'verification_type'     => $varification,
                    'verification_amount'   => $verificationtypes->verification_amount,
                    'status'                => '0',
                    'documentRequired'      => $verificationtypes->docRequired,
                    'isAddress'             => $verificationtypes->isAddress,
                    'docIds'                => '',
                    'addressIds'            => '',
                    'tat'                   => $verificationtypes->tat,
                ];

                $totalAmount[] = $verificationtypes->verification_amount;

                // print_r($orders);

                OrderHistory::create($orders);
            }

            $payments = [
                'worker_id'                 => $request->worker_id,
                'company_id'                => $request->company_id,
                'additional_amount'         => array_sum($totalAmount),
                'additional_amount_status'  => '0',
                'payment_request_id'        => '',
                'temp_id'                   => $order_id,
                'discount'                  => 0,
                'promocode'                 => '',
                'gst'                       => (18 / 100) * array_sum($totalAmount),
                'subTotal'                  => ((18 / 100) * array_sum($totalAmount)) + array_sum($totalAmount),
            ];

            // print_r($payments);

            PaymentHistory::create($payments);

            return redirect('orders')->with('success', 'Order created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($order_id)
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'link' => "/orders",
                'name' => "Orders List"
            ],
            [
                'name' => "Order Details"
            ]
        ];

        $orders = PaymentHistory::with(array('employer','employees'))->where('temp_id', $order_id)->first();
        $tasks  = OrderHistory::with('verification')->where('order_id', $order_id)->get();
        $employeePicture = DB::table('employee_pictures')->select('photo')->where('worker_id', $orders->worker_id)->first();

        return view('/orders/orders-details-list', [
            'breadcrumbs' => $breadcrumbs,
            'orders'      => $orders,
            'tasks'       => $tasks,
            'employeePicture' => $employeePicture,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function task_details($order_id,$task_id)
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'link' => "/orders",
                'name' => "Orders List"
            ],
            [
                'link' => "/orders/view/".$order_id,
                'name' => "Orders Detail"
            ],
            [
                'name' => "Task Details"
            ]
        ];

        $orders = PaymentHistory::with(array('employer','employees'))->where('temp_id', $order_id)->first();
        $tasks = DB::table('order_histories')
            ->join('verification_types', 'order_histories.verification_type', '=', 'verification_types.id')
            ->select('order_histories.*', 'verification_types.verification_type', 'verification_types.id as verificationId', 'verification_types.document_type_id as doc_type')
            ->where('task_id', $task_id)
            ->get();
        $antecedents_fields = AntecedentsField::where('order_history_id', $task_id)
            ->orderBy('verification_field_id','asc')
            ->get();
        $action_summaries = DB::table('action_summaries')
            ->join('users', 'action_summaries.user_id', '=', 'users.id')
            ->select('action_summaries.*', 'users.name')
            ->where('order_history_task_id', $task_id)
            ->orderBy('id', 'desc')
            ->get();
        $task_comments = DB::table('task_comments')
            ->join('users', 'task_comments.user_id', '=', 'users.id')
            ->select('task_comments.*', 'users.name')
            ->orderBy('id', 'desc')
            ->get();
        $docFile = UploadedDocument::where([
                'worker_id' => $orders->worker_id,
                'company_id'=> $orders->company_id,
                'docTypeId' => $tasks[0]->doc_type
            ])->select('filesName')->first();
        $users = DB::table('users')->where('id', '!=', Auth::user()->id)->get();

        // $candidate_documents = DB::table('uploaded_documents')
        //     ->join('document_types', 'uploaded_documents.docTypeId', '=', 'document_types.id')
        //     ->select('uploaded_documents.*', 'document_types.documentName')
        //     ->where(array('uploaded_documents.worker_id' => $orders->worker_id, 'uploaded_documents.orderId' => ''))
        //     ->get();

        $candidate_documents = DB::table('uploaded_documents')
            ->leftJoin('document_types', 'uploaded_documents.docTypeId', '=', 'document_types.id')
            ->select('uploaded_documents.*', 'document_types.documentName')
            ->where(array('uploaded_documents.worker_id' => $orders->worker_id, 'uploaded_documents.report_view' => '0'))
            ->get();
        
        $internal_documents = DB::table('uploaded_documents')
            ->leftJoin('document_types', 'uploaded_documents.docTypeId', '=', 'document_types.id')
            ->select('uploaded_documents.*', 'document_types.documentName')
            ->where(array('uploaded_documents.worker_id' => $orders->worker_id, 'uploaded_documents.report_view' => '1'))
            ->get();
        // $candidate_documents = DB::table('uploaded_documents')->where('orderId', $task_id)->get();
        // $internal_documents = DB::table('uploaded_documents')->where('orderId', $task_id)->get();
        $messages = DB::table('messages')->where('orderId', $task_id)->get();

        $employeePicture = DB::table('employee_pictures')->select('photo')->where('worker_id', $orders->worker_id)->first();

        if(!empty($tasks[0]->verificationId)){
            $verification_fields = VerificationFields::where('verification_type_id', $tasks[0]->verificationId)->get();
        } else {
            $verification_fields = '';
        }

        return view('/orders/orders-task-details', [
            'breadcrumbs'           => $breadcrumbs,
            'orders'                => $orders,
            'tasks'                 => $tasks,
            'verification_fields'   => $verification_fields,
            'antecedents_fields'    => $antecedents_fields,
            'action_summaries'      => $action_summaries,
            'task_comments'         => $task_comments,
            'users'                 => $users,
            'candidate_documents'   => $candidate_documents,
            'internal_documents'    => $internal_documents,
            'messages'              => $messages,
            'employeePicture'       => $employeePicture,
            'docFile'               => $docFile,
        ]);
    }

    public function antecedents_store($order_id, $task_id, Request $request)
    {
        $data           = [];
        $match_status[] = '0';

        foreach ($request->antecedents_values as $key => $antecedents) {

            // $data = [
            //     'order_history_id'      => $task_id,
            //     'verification_field_id' => $request->fields_id[$key],
            //     'antecedents_value'     => $request->antecedents_values[$key],
            //     'match_status'          => $request->match_status[$key] ?? 'Verified',
            //     'user_id'               => Auth::user()->id,
            // ];
            
            // if($request->antecedents_types[$key] != 'FILE'){
            //     $data['antecedents_value'] = $request->antecedents_values[$key];
            // } else {                
            //     $filename   = $_FILES['antecedents_values']['name'][$key];
            //     $tempid     = rand(10000,99999);
            //     $s3         = AWS::createClient('s3');
            //     $fileData   = $s3->putObject(array(
            //         'Bucket'        => 'cdn.gettruehelp.com',
            //         'Key'           => 'img/'.md5($tempid).$filename,
            //         'SourceFile'    => $_FILES['antecedents_values']['tmp_name'][$key],
            //         'StorageClass'  => 'STANDARD',
            //         'ContentType'   => mime_content_type($filename),
            //         'ACL'           => 'public-read',
            //     ));
            //     $data['antecedents_value'] = $fileData['ObjectURL'] ?? '';
            // }            

            if($AntecedentsField = AntecedentsField::where([
                'order_history_id'      => $task_id, 
                'verification_field_id' => $request->fields_id[$key]
            ])->first()){
                $AntecedentsField->antecedents_value = $request->antecedents_values[$key];
                $AntecedentsField->match_status = $request->match_status_val[$key];
                $AntecedentsField->save();    
            } else {
                AntecedentsField::create([
                    'order_history_id'      => $task_id,
                    'verification_field_id' => $request->fields_id[$key],
                    'antecedents_value'     => $request->antecedents_values[$key] ?? '',
                    'match_status'          => $request->match_status_val[$key],
                    'user_id'               => Auth::user()->id,
                ]);
            }

            if($request->match_status_val[$key] == 'Verified'){
                $match_status[] = '0';
            } elseif($request->match_status_val[$key] == 'Attention Required'){
                $match_status[] = '1';
            } else {
                $match_status[] = '2';
            }
        }

        if($orderDtls = OrderHistory::where([
            'task_id' => $task_id
        ])->first()){
            $orderDtls->match_status = max($match_status);
            $orderDtls->save();
        }

        ActionSummary::create([
            'order_history_task_id' => $task_id,
            'type'                  => 'ANTECEDENTS_UPDATE',
            'message'               => 'Antecedents/Reply Fields Updated',
            'user_id'               => Auth::user()->id,
        ]);

        $this->generate_report($task_id, false);

        return redirect('/orders/task/'.$order_id.'/'.$task_id)->with('success', 'Task Updated successfully!');
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

    public function get_employee(Request $request)
    {
        $employees  = Employee::where(array('company_id' => $request->company_id, 'source' => $request->source))->get();       

        if($employees){
            echo '<option value="">Select Employee</option>';
            foreach ($employees as $employee) {
                echo '<option value="'.$employee->id.'">'.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.'</option>';
            }
        }
    }

    public function number_of_working_days($from, $to)
    {
        $workingDays = [1, 2, 3, 4, 5];
        $holidayDays = ['*-12-25', '*-01-01', '2013-12-23']; # variable and fixed holidays

        $from = new DateTime($from);
        $to = new DateTime($to);
        $to->modify('+1 day');
        $interval = new DateInterval('P1D');
        $periods = new DatePeriod($from, $interval, $to);

        $days = 0;
        foreach ($periods as $period) {
            if (!in_array($period->format('N'), $workingDays)) continue;
            if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
            if (in_array($period->format('*-m-d'), $holidayDays)) continue;
            $days++;
        }
        return $days;
    }

    public function add_task_comment($order_id, $task_id, Request $request)
    {
        TaskComment::create([
            'order_history_task_id' => $task_id,
            'message'               => $request->message,
            'user_id'               => Auth::user()->id,
        ]);

        ActionSummary::create([
            'order_history_task_id' => $task_id,
            'type'                  => 'COMMENT',
            'message'               => $request->message,
            'user_id'               => Auth::user()->id,
        ]);

        return redirect('/orders/task/'.$order_id.'/'.$task_id)->with('success', 'Comment Added successfully!');
    }

    public function raise_insuff($order_id, $task_id, Request $request)
    {
        Insuff::create([
            'order_history_task_id' => $task_id,
            'message'               => $request->message,
            'user_id'               => Auth::user()->id,
        ]);

        ActionSummary::create([
            'order_history_task_id' => $task_id,
            'type'                  => 'RAISE_INSUFF',
            'message'               => $request->message,
            'user_id'               => Auth::user()->id,
        ]);

        $orderHistory = OrderHistory::where('task_id', $task_id)->first();
        $orderHistory->task_status = '3';
        $orderHistory->save();

        return redirect('/orders/task/'.$order_id.'/'.$task_id)->with('success', 'Insuff Raised successfully!');
    }

    public function escalate($order_id, $task_id, Request $request)
    {
        Escalation::create([
            'order_history_task_id' => $task_id,
            'escalate_to'           => $request->escalate_to,
            'message'               => $request->message,
            'user_id'               => Auth::user()->id,
        ]);

        ActionSummary::create([
            'order_history_task_id' => $task_id,
            'type'                  => 'ESCLATE',
            'message'               => 'Escalate to: '.$request->escalate_name.'. '.$request->message,
            'user_id'               => Auth::user()->id,
        ]);

        $orderHistory = OrderHistory::where('task_id', $task_id)->first();
        $orderHistory->task_status = '2';
        $orderHistory->save();

        UserNotification::create([
            'user_id'   => $task_id,
            'type'      => 'ESCLATE',
            'message'   => 'Escalate By: '.Auth::user()->name.'. '.$request->message,
            'is_view'   => '0',
        ]);

        return redirect('/orders/task/'.$order_id.'/'.$task_id)->with('success', 'Insuff Raised successfully!');
    }

    public function fileupload($order_id, $task_id, Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'files' => 'required',
        ]);

        $tasks  = OrderHistory::where('order_id', $order_id)->first();

        if($request->hasFile('files')) {
            $image          = $request->file('files');
            $filename       = $image->getClientOriginalName();
            $tempid         = rand(10000,99999);

            $s3 = AWS::createClient('s3');
            $fileData = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'img/'.md5($tempid).$filename,
                'SourceFile'    => $request->file('files'),
                'StorageClass'  => 'STANDARD',
                'ContentType'   => $request->file('files')->getMimeType(),
                'ACL'           => 'public-read',
            ));

            if($fileData){
                $photo = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
            }
        }

        // echo '<pre>';
        // print_r($request->all());
        // exit;

        DB::table('uploaded_documents')->insert([
            'filesName'     => $photo,
            'worker_id'     => $tasks->worker_id,
            'company_id'    => $tasks->company_id,
            'docName'       => $request->name,
            'orderId'       => $task_id,
            'report_view'   => $request->report_view ?? '0',
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect('/orders/task/'.$order_id.'/'.$task_id)->with('success', 'File uploaded successfully!');
    }

    public function send_message(Request $request)
    {

        $tasks  = OrderHistory::where('order_id', $request->orderId)->first();

        $data = DB::table('messages')->insert([
            'worker_id'         => $tasks->worker_id,
            'company_id'        => $tasks->company_id,
            'orderId'           => $request->orderId,
            'message_title'     => $request->message_title,
            'message_body'      => $request->message_body,
            'message_status'    => '0',
            'user_id'           => Auth::id(),
            'verification_type' => $request->verification_type,
            'created_at'        => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'response' => [
                'status'    => 'success',
                'data'      => "MSG_SENT",
                'message'   => 'message sent to the client'
            ]
        ], 200);
    }

    public function generate_report1($task_id, $regenerate = false)
    {
        $taskDetails = OrderHistory::where('task_id', $task_id)->first();
        $employeeDetails = Employee::where('id', $taskDetails->worker_id)->first();
        $employeeAddress = Address::where(array('worker_id' => $employeeDetails->id, 'addressType' => 'PE'))->first();
        $verificationTypes  = VerificationType::where('id', $taskDetails->verification_type)->first();
        $verificationFields  = DB::table('verification_fields as fields')
            ->leftJoin('antecedents_fields as value', 'fields.id', '=', 'value.verification_field_id')
            ->select('fields.fields_name', 'value.antecedents_value', 'value.match_status')
            ->where('value.order_history_id', $task_id)
            ->get();

        // return view('/templates/aadharn', [
        //     'taskDetails'           => $taskDetails,
        //     'employeeDetails'       => $employeeDetails,
        //     'employeeAddress'       => $employeeAddress,
        //     'verificationTypes'     => $verificationTypes,
        //     'verificationFields'     => $verificationFields,
        // ]);

        return PDF::loadView('/templates/aadharn', [
            'taskDetails'           => $taskDetails,
            'employeeDetails'       => $employeeDetails,
            'employeeAddress'       => $employeeAddress,
            'verificationTypes'     => $verificationTypes,
            'verificationFields'     => $verificationFields,
        ])->save(storage_path('reports/'.$task_id.date('-Y-m-d').'.pdf'))->stream($task_id.date('-Y-m-d').'.pdf');
    }

    public function pdf_view_report($task_id, Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // exit;

        $taskDetails = OrderHistory::where('task_id', $task_id)->first();
        $employeeDetails = Employee::where('id', $taskDetails->worker_id)->first();
        $employerDetails = Employer::where('id', $taskDetails->company_id)->first();
        $employeeAddress = Address::where(array('worker_id' => $employeeDetails->id, 'addressType' => 'PE'))->first();
        $verificationTypes = VerificationType::where('id', $taskDetails->verification_type)->first();
        $verificationFields = $request->all();

        $documents = DB::table('uploaded_documents')
            ->select('filesName')
            ->where(array('orderId' => $task_id, 'report_view' => '1'))
            ->get();

        $employeePicture = DB::table('employee_pictures')->select('photo')->where('worker_id', $taskDetails->worker_id)->first();

        return PDF::loadView('templates/aadhar_view_report', [
            'taskDetails'           => $taskDetails,
            'employeeDetails'       => $employeeDetails,
            'employerDetails'       => $employerDetails,
            'employeeAddress'       => $employeeAddress,
            'verificationTypes'     => $verificationTypes,
            'verificationFields'    => $verificationFields,
            'documents'             => $documents,
            'employeePicture'       => $employeePicture,
        ])->save(storage_path('reports/'.$task_id.date('-Y-m-d').'.pdf'))->stream($task_id.date('-Y-m-d').'.pdf');
    }

    public function generate_report($task_id, $regenerate = false)
    {
        $taskDetails = OrderHistory::where('task_id', $task_id)->first();
        $employeeDetails = Employee::where('id', $taskDetails->worker_id)->first();
        $employerDetails = Employer::where('id', $taskDetails->company_id)->first();
        $employeeAddress = Address::where(array('worker_id' => $employeeDetails->id, 'addressType' => 'PE'))->first();
        $verificationTypes = VerificationType::where('id', $taskDetails->verification_type)->first();
        $verificationFields = DB::table('verification_fields as fields')
            ->leftJoin('antecedents_fields as value', 'fields.id', '=', 'value.verification_field_id')
            ->select('fields.fields_name', 'value.antecedents_value', 'value.match_status')
            ->where('value.order_history_id', $task_id)
            ->get();

        $documents = DB::table('uploaded_documents')
            ->select('filesName')
            ->where(array('orderId' => $task_id, 'report_view' => '1'))
            ->get();

        $employeePicture = DB::table('employee_pictures')->select('photo')->where('worker_id', $taskDetails->worker_id)->first();

        $pdf = PDF::loadView('/templates/aadharn', [
            'taskDetails'           => $taskDetails,
            'employeeDetails'       => $employeeDetails,
            'employerDetails'       => $employerDetails,
            'employeeAddress'       => $employeeAddress,
            'verificationTypes'     => $verificationTypes,
            'verificationFields'    => $verificationFields,
            'documents'             => $documents,
            'employeePicture'       => $employeePicture,
        ]);

        $fileName   = $task_id.date('-Y-m-d').'.pdf';

        if( $pdf->save(storage_path('reports/'.$fileName) ) ) {
            
            $s3 = AWS::createClient('s3');
            $uploadReport = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'reports/'.$fileName,
                'SourceFile'    => storage_path('reports/'.$fileName),
            ));

            if($uploadReport){
                $taskDetails->status      = '1';
                $taskDetails->task_status = '7';
                $taskDetails->report_file = $uploadReport['ObjectURL'] ? $uploadReport['ObjectURL'] : '';
                $taskDetails->save();

                ActionSummary::create([
                    'order_history_task_id' => $task_id,
                    'type'                  => 'GENERATE_REPORT',
                    'message'               => 'Report Generated',
                    'user_id'               => Auth::user()->id,
                ]);

                if($taskDetails->match_status == 0){
                    $notification = 'CONGRATS! The report on "'.$employeeDetails->first_name.' '.$employeeDetails->middle_name.' '.$employeeDetails->last_name.'" for "'.$verificationTypes->verification_type.'", order number ['.$task_id.']  came back "POSITIVE"';
                } else {
                    $notification = 'BEWARE! The report on "'.$employeeDetails->first_name.' '.$employeeDetails->middle_name.' '.$employeeDetails->last_name.'" for "'.$verificationTypes->verification_type.'", order number ['.$task_id.']  came back "NEGATIVE"';
                }

                CompanyNotifications::create([
                    'company_id'   => $taskDetails->company_id,
                    'worker_id'    => $taskDetails->worker_id,
                    'notification' => $notification,
                    'status'       => '0'
                ]);

                Storage::delete(storage_path('reports/'.$fileName));

                OneSignal::sendNotificationUsingTags(
                    "TrueHelp Report Generated",
                    array([
                        "field"     => "tag",
                        "key"       => "userid",
                        "relation"  => "=",
                        "value"     => $taskDetails->company_id
                    ]),
                    $url = 'https://home.gettruehelp.com/view-report.php?o=4d39626a7376334433336850654857357361647877773d3d', 
                    $data = null, 
                    $buttons = null, 
                    $schedule = null
                );

                // return response()->json([
                //     'response' => [
                //         'status'    => 'SUCCESS',
                //         'message'   => "Report Generated",
                //         'data'      => $taskDetails,
                //     ]
                // ], 200);
             } //else {
            //     return response()->json([
            //         'response' => [
            //             'status'    => 'FAILED',
            //             'message'   => "Somthing Wrong! Try Again",
            //         ]
            //     ], 500);
            // }

        }
    }

    public function view_report($task_id)
    {
        $taskDetails = OrderHistory::select('report_file')->where('task_id', $task_id)->first();

        return view('/orders/view-report', [
            'report_file'   => $taskDetails->report_file,
        ]);
    }
}