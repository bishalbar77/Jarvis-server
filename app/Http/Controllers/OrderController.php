<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Auth;
use Carbon\Carbon;
use App\PaymentHistory;
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
use App\TaskTypeSeverity;
use App\DocumentType;

use App\Order;
use App\OrderHistory;
use App\OrderTask;
use App\OrderType;
use App\TaskType;
use App\TaskHistory;
use App\UserDoc;
use App\TaskHistoryDoc;
use App\UserAddress;
use App\Url;

use DateTime;
use DatePeriod;
use DateInterval;
use DB;
use AWS;
use Aws\S3\S3Client; 
use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;
use PDF;
use OCR;
use OneSignal;
use Geocoder;

class OrderController extends Controller
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
            $filter['orders.order_number'] = $request->s;
        } else {
            $s = '';
        }

        if(isset($request->status)){
            $status = $request->status;
            $filter['orders.status'] = $request->status == 'active' ? 'A' : 'I';
        } else {
            $status = '';
        }

        if($request->source){
            $source = $request->source;
            $filter['employers.source_type'] = $request->source;
        } else {
            $source = '';
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

        if($request->s != ''){
            $orders = DB::table('orders')
                ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
                ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
                ->select('orders.*', 'employers.employer_custom_id as employer_code', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employer_user.first_name as employer_first_name', 'employer_user.middle_name as employer_middle_name', 'employer_user.last_name as employer_last_name', 'employees.employee_custom_id as employees_code', 'employees_user.first_name as employees_first_name', 'employees_user.middle_name as employees_middle_name', 'employees_user.last_name as employees_last_name')
                ->where($filter)
                ->orWhere('employees_user.first_name', 'like', '%'.$request->s.'%')
                ->orWhere('employees_user.middle_name', 'like', '%'.$request->s.'%')
                ->orWhere('employees_user.last_name', 'like', '%'.$request->s.'%')
                ->groupBy('orders.id')
                ->orderBy('orders.id', 'desc')
                ->paginate($perpage);
        } else {
            $orders = DB::table('orders')
                ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
                ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
                ->select('orders.*', 'employers.employer_custom_id as employer_code', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employer_user.first_name as employer_first_name', 'employer_user.middle_name as employer_middle_name', 'employer_user.last_name as employer_last_name', 'employees.employee_custom_id as employees_code', 'employees_user.first_name as employees_first_name', 'employees_user.middle_name as employees_middle_name', 'employees_user.last_name as employees_last_name')
                ->where($filter)
                ->groupBy('orders.id')
                ->orderBy('orders.id', 'desc')
                ->paginate($perpage);
        }

        foreach ($orders as $key => $order) {
            if($order->status == 'COMPLETE'){
                $orders[$key]->tat_days = $this->number_of_working_days($order->received_date, $order->tat);
                if($this->number_of_working_days($order->received_date, $order->tat) > 0){
                    $orders[$key]->tat_color = 'success';
                } else {
                    $orders[$key]->tat_color = 'danger';
                }
            } else {
                $orders[$key]->tat_days = $this->number_of_working_days(date('Y-m-d'), $order->tat);
                if($this->number_of_working_days(date('Y-m-d'), $order->tat) > 0){
                    $orders[$key]->tat_color = 'success';
                } else {
                    $orders[$key]->tat_color = 'danger';
                }
            }
        }

        return view('orders.list', [
            'breadcrumbs' => $breadcrumbs,
            'orders' => $orders,
            'filter' => $filter,
            'perpage' => $perpage,
            's' => $s,
            'source' => $source,
            'status' => $status
        ]);
    }

    public function tasks(Request $request)
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
            $filter['order_tasks.task_number'] = $request->s;
        } else {
            $s = '';
        }

        if(isset($request->type)){
            $type = $request->type;
            $filter['order_tasks.task_display_id'] = $request->type;
        } else {
            $type = '';
        }

        if(isset($request->status)){
            $status = $request->status;
            $filter['order_tasks.status'] = $request->status;
        } else {
            $status = '';
        }

        if(isset($request->employer_id)){
            $employer_id = $request->employer_id;
            $filter['orders.employer_id'] = $request->employer_id;
        } else {
            $employer_id = '';
        }

        if($request->source){
            $source = $request->source;
            $filter['employers.source_type'] = $request->source;
        } else {
            $source = '';
        }

        if($request->severity){
            $severity = $request->severity;
            $filter['task_history.severity'] = $request->severity;
        } else {
            $severity = '';
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

        if($request->emp != ''){
            $orders = DB::table('order_tasks')
                ->leftJoin('orders', 'order_tasks.order_id', '=', 'orders.id')
                ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
                ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
                ->leftJoin('task_history', function($query) {
                    $query->on('order_tasks.id','=','task_history.task_id')
                        ->whereRaw('task_history.id IN (select MAX(a2.id) from task_history as a2 join order_tasks as u2 on u2.id = a2.task_id group by u2.id order by u2.id desc)');
                    })
                ->select('order_tasks.*', 'orders.id as orderId', 'employers.employer_custom_id as employer_code', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employer_user.first_name as employer_first_name', 'employer_user.middle_name as employer_middle_name', 'employer_user.last_name as employer_last_name', 'employees.employee_custom_id as employees_code', 'employees_user.first_name as employees_first_name', 'employees_user.middle_name as employees_middle_name', 'employees_user.last_name as employees_last_name', 'task_history.severity')
                ->where($filter)
                ->orWhere('employees_user.first_name', 'like', '%'.$request->emp.'%')
                ->orWhere('employees_user.middle_name', 'like', '%'.$request->emp.'%')
                ->orWhere('employees_user.last_name', 'like', '%'.$request->emp.'%')
                ->orWhere('order_tasks.task_number', 'like', '%'.$request->emp.'%')
                ->groupBy('order_tasks.id')
                ->orderBy('order_tasks.id', 'desc')
                ->paginate($perpage);  
        } else {
            $orders = DB::table('order_tasks')
                ->leftJoin('orders', 'order_tasks.order_id', '=', 'orders.id')
                ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
                ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
                ->leftJoin('task_history', function($query) {
                    $query->on('order_tasks.id','=','task_history.task_id')
                        ->whereRaw('task_history.id IN (select MAX(a2.id) from task_history as a2 join order_tasks as u2 on u2.id = a2.task_id group by u2.id order by u2.id desc)');
                    })
                ->select('order_tasks.*', 'orders.id as orderId', 'employers.employer_custom_id as employer_code', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employer_user.first_name as employer_first_name', 'employer_user.middle_name as employer_middle_name', 'employer_user.last_name as employer_last_name', 'employees.employee_custom_id as employees_code', 'employees_user.first_name as employees_first_name', 'employees_user.middle_name as employees_middle_name', 'employees_user.last_name as employees_last_name', 'task_history.severity')
                ->where($filter)
                ->groupBy('order_tasks.id')
                ->orderBy('order_tasks.id', 'desc')
                ->paginate($perpage);
        }

        foreach ($orders as $key => $order) {
            if($order->status == 'COMPLETE'){
                $orders[$key]->tat_days = $this->number_of_working_days($order->received_date, $order->tat);
                if($this->number_of_working_days($order->received_date, $order->tat) > 0){
                    $orders[$key]->tat_color = 'success';
                } else {
                    $orders[$key]->tat_color = 'danger';
                }
            } else {
                $orders[$key]->tat_days = $this->number_of_working_days(date('Y-m-d'), $order->tat);
                if($this->number_of_working_days(date('Y-m-d'), $order->tat) > 0){
                    $orders[$key]->tat_color = 'success';
                } else {
                    $orders[$key]->tat_color = 'danger';
                }
            }
        }

        $employers = Employer::select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id')
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->get();

        return view('/orders/tasks-list', [
            'breadcrumbs' => $breadcrumbs,
            'orders' => $orders,
            'filter' => $filter,
            'perpage' => $perpage,
            's' => $s,
            'source' => $source,
            'type' => $type,
            'status' => $status,
            'severity' => $severity,
            'employers' => $employers,
            'employer_id' => $employer_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $source             = $request->source ? $request->source : 'B2B';
        $employers          = Employer::where(array('source_type' => $source))
                                ->leftJoin('users', 'employers.user_id', '=', 'users.id')
                                ->select('employers.id','employers.b2b_company_name','employers.b2b_brand_name','users.first_name','users.middle_name','users.last_name')
                                ->get();
        $employees          = Employee::where(array('status' => 'I'))
                                ->leftJoin('users', 'employees.user_id', '=', 'users.id')
                                ->select('employees.id','users.first_name','users.middle_name','users.last_name')
                                ->get();
        $verificationtypes  = VerificationType::where(array('status' => 'A', 'source' => $source))->get();

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
        return view('orders.create', [
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

        // echo "<pr>";
        // print_r($request->all());
        // exit;
        // $request->validate([
        //     'source' => 'required',
        //     'employer_id' => 'required',
        //     'worker_id' => 'required',
        //     'varifications' => 'required',
        // ]);

        $order_id    = rand(1000000,9999999);
        $totalAmount = array();

        if($request->varifications){
            foreach ($request->varifications as $key => $verification) {
                $verification = VerificationType::where('id', $verification)->select('id', 'name', 'tat')->first();
                $maxTat[] = $verification->tat;
                $order_ids[] = $verification->id;
                $order_name[] = $verification->name;
            }
        }
        
        $employers = Employer::find($request->employer_id);
        $employees = Employee::find($request->employee_id);

        $max_tat = max($maxTat);

        $date = date('Y-m-d');
        $received_date = $request->received_date ? date('Y-m-d', strtotime($request->received_date)) : date('Y-m-d');
        $actual_tat = $this->getFutureBusinessDay($max_tat, $received_date, $holiday_dates_ymd = []);

        DB::beginTransaction();

        $orders = new Order;
        $orders->order_number = $employers->employer_custom_id.'-'.$employees->employee_custom_id;
        $orders->order_display_ids = implode(',', $order_ids);
        $orders->order_dispaly_desc = implode(',', $order_name);
        $orders->status = 'CREATED';
        $orders->priority = 'NORMAL';
        $orders->tat = $actual_tat;
        $orders->employer_id = $request->employer_id;
        $orders->employee_id = $request->employee_id;
        $orders->received_date = $received_date;
        $orders->save();

        $orderhistory = new OrderHistory;
        $orderhistory->action = 'CREATED';
        $orderhistory->order_id = $orders->id;
        $orderhistory->order_status = 'CREATED';
        $orderhistory->action_by = Auth::id();
        $orderhistory->save();

        if($request->varifications){
            foreach ($request->varifications as $key => $verificId) {

                $verifications = VerificationType::where('id', $verificId)->first();

                if(isset($verifications)){
                    $task_deps = explode('|', $verifications->task_deps);

                    if(count($task_deps) > 0){
                        foreach ($task_deps as $key => $task_dep) {

                            $task_num = OrderTask::select('id')->orderBy('id', 'desc')->first();

                            if($task_num->id <= 9){
                                $task_number = '000'.($task_num->id + 1);
                            } elseif($task_num->id <= 99) {
                                $task_number = '00'.($task_num->id + 1);
                            } elseif($task_num->id <= 999) {
                                $task_number = '0'.($task_num->id + 1);
                            } else {
                                $task_number = $task_num->id + 1;
                            }

                            $task_type = DB::table('task_types')->where('task_type', $task_dep)->first();

                            if($task_type->task_type == 'CRC' || $task_type->task_type == 'AV_PHYSICAL' || $task_type->task_type == 'AV_DIGITAL' || $task_type->task_type == 'AV_POSTAL'){
                                foreach ($request->input($task_type->task_type.'_ADDRESS') as $key => $value) {
                                    $ordertasks = new OrderTask;
                                    $ordertasks->task_number = $orders->order_number.'-'.$task_number.'-'.date('my');
                                    $ordertasks->task_display_id = $task_type->task_type;
                                    $ordertasks->order_id = $orders->id;
                                    $ordertasks->task_type = $task_type->id;
                                    $ordertasks->employer_id = $request->employer_id;
                                    $ordertasks->employee_id = $request->employee_id;
                                    $ordertasks->priority = 'NORMAL';
                                    $ordertasks->tat = $this->getFutureBusinessDay($task_type->tat, $received_date, $holiday_dates_ymd = []);
                                    $ordertasks->status = 'CREATED';
                                    $ordertasks->received_date = $received_date;
                                    $ordertasks->save();

                                    $candidate_data = json_encode([
                                        'address_id' => $request->input($task_type->task_type.'_ADDRESS')[$key]
                                    ]);

                                    $taskhistory = new TaskHistory;
                                    $taskhistory->action = 'CREATED';
                                    $taskhistory->task_id = $ordertasks->id;
                                    $taskhistory->task_status = 'CREATED';
                                    $taskhistory->action_by = Auth::id();
                                    $taskhistory->candidate_data = $candidate_data;
                                    $taskhistory->antecedants_data = '';
                                    $taskhistory->save();
                                }
                            } else if($task_type->task_type == 'EMPLOYMENT_CHECK'){
                                foreach ($request->input('employer_name') as $key => $value) {
                                    $ordertasks = new OrderTask;
                                    $ordertasks->task_number = $orders->order_number.'-'.$task_number.'-'.date('my');
                                    $ordertasks->task_display_id = $task_type->task_type;
                                    $ordertasks->order_id = $orders->id;
                                    $ordertasks->task_type = $task_type->id;
                                    $ordertasks->employer_id = $request->employer_id;
                                    $ordertasks->employee_id = $request->employee_id;
                                    $ordertasks->priority = 'NORMAL';
                                    $ordertasks->tat = $this->getFutureBusinessDay($task_type->tat, $received_date, $holiday_dates_ymd = []);
                                    $ordertasks->status = 'CREATED';
                                    $ordertasks->received_date = $received_date;
                                    $ordertasks->save();

                                    $candidate_data = json_encode([
                                        'employer_name' => $request->input('employer_name')[$key],
                                        'employment_period' => $request->input('employment_period')[$key],
                                        'designation' => $request->input('designation')[$key],
                                        'salary' => $request->input('salary')[$key],
                                        'employee_code' => $request->input('employee_code')[$key],
                                        'reporting_manager' => $request->input('reporting_manager')[$key],
                                        'manager_contact' => $request->input('manager_contact')[$key],
                                        'hr_name' => $request->input('hr_name')[$key],
                                        'hr_email' => $request->input('hr_email')[$key],
                                        'hr_contact_details' => $request->input('hr_contact_details')[$key],
                                    ]);

                                    $taskhistory = new TaskHistory;
                                    $taskhistory->action = 'CREATED';
                                    $taskhistory->task_id = $ordertasks->id;
                                    $taskhistory->task_status = 'CREATED';
                                    $taskhistory->action_by = Auth::id();
                                    $taskhistory->candidate_data = $candidate_data;
                                    $taskhistory->antecedants_data = '';
                                    $taskhistory->save();
                                }
                            } else if($task_type->task_type == 'EDUCATION_VERIFICATION'){
                                foreach ($request->input('edu_course_name') as $key => $value) {
                                    $ordertasks = new OrderTask;
                                    $ordertasks->task_number = $orders->order_number.'-'.$task_number.'-'.date('my');
                                    $ordertasks->task_display_id = $task_type->task_type;
                                    $ordertasks->order_id = $orders->id;
                                    $ordertasks->task_type = $task_type->id;
                                    $ordertasks->employer_id = $request->employer_id;
                                    $ordertasks->employee_id = $request->employee_id;
                                    $ordertasks->priority = 'NORMAL';
                                    $ordertasks->tat = $this->getFutureBusinessDay($task_type->tat, $received_date, $holiday_dates_ymd = []);
                                    $ordertasks->status = 'CREATED';
                                    $ordertasks->received_date = $received_date;
                                    $ordertasks->save();

                                    $candidate_data = json_encode([
                                        'edu_course_name' => $request->input('edu_course_name')[$key],
                                        'edu_roll_no' => $request->input('edu_roll_no')[$key],
                                        'edu_passing_year' => $request->input('edu_passing_year')[$key],
                                        'edu_school_name' => $request->input('edu_school_name')[$key]
                                    ]);

                                    $taskhistory = new TaskHistory;
                                    $taskhistory->action = 'CREATED';
                                    $taskhistory->task_id = $ordertasks->id;
                                    $taskhistory->task_status = 'CREATED';
                                    $taskhistory->action_by = Auth::id();
                                    $taskhistory->candidate_data = $candidate_data;
                                    $taskhistory->antecedants_data = '';
                                    $taskhistory->save();
                                }
                            } else if($task_type->task_type == 'PAN_VERIFICATION'){

                                $fileData = array();
                                $users = Employee::find($request->employee_id);

                                if($request->hasFile('pan_file')) {
                                    $image = $request->file('pan_file');
                                    $filename = $image->getClientOriginalName();
                                    $tempid = rand(10000,99999);
                        
                                    $s3 = AWS::createClient('s3');
                                    $fileData = $s3->putObject(array(
                                        'Bucket'        => 'cdn.gettruehelp.com',
                                        'Key'           => 'documents/'.md5($tempid).$filename,
                                        'SourceFile'    => $request->file('pan_file'),
                                        'StorageClass'  => 'STANDARD',
                                        'ContentType'   => $request->file('pan_file')->getMimeType(),
                                        'ACL'           => 'public-read',
                                    ));
                                    
                                    if($fileData){
                                        $userdoc = new UserDoc;
                                        $userdoc->user_id = $users->user_id;
                                        $userdoc->doc_type_id = 5;
                                        $userdoc->cosmos_id = rand(1,9999999);
                                        $userdoc->doc_number = $request->input('pan_no');
                                        $userdoc->doc_url = isset($fileData['ObjectURL']) && !empty($fileData['ObjectURL']) ? $fileData['ObjectURL'] : '';
                                        $userdoc->uploaded_by = Auth::id();
                                        $userdoc->save();
                                    }
                                }

                                $ordertasks = new OrderTask;
                                $ordertasks->task_number = $orders->order_number.'-'.$task_number.'-'.date('my');
                                $ordertasks->task_display_id = $task_type->task_type;
                                $ordertasks->order_id = $orders->id;
                                $ordertasks->task_type = $task_type->id;
                                $ordertasks->employer_id = $request->employer_id;
                                $ordertasks->employee_id = $request->employee_id;
                                $ordertasks->priority = 'NORMAL';
                                $ordertasks->tat = $this->getFutureBusinessDay($task_type->tat, $received_date, $holiday_dates_ymd = []);
                                $ordertasks->status = 'CREATED';
                                $ordertasks->received_date = $received_date;
                                $ordertasks->save();

                                $candidate_data = json_encode([
                                    'pan_dob' => $request->input('pan_dob'),
                                    'pan_no' => $request->input('pan_no'),
                                    'name_as_per_pan' => $request->input('name_as_per_pan'),
                                    'pan_file' => $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '',
                                ]);

                                $taskhistory = new TaskHistory;
                                $taskhistory->action = 'CREATED';
                                $taskhistory->task_id = $ordertasks->id;
                                $taskhistory->task_status = 'CREATED';
                                $taskhistory->action_by = Auth::id();
                                $taskhistory->candidate_data = $candidate_data;
                                $taskhistory->antecedants_data = '';
                                $taskhistory->save();
                            } else {
                                $ordertasks = new OrderTask;
                                $ordertasks->task_number = $orders->order_number.'-'.$task_number.'-'.date('my');
                                $ordertasks->task_display_id = $task_type->task_type;
                                $ordertasks->order_id = $orders->id;
                                $ordertasks->task_type = $task_type->id;
                                $ordertasks->employer_id = $request->employer_id;
                                $ordertasks->employee_id = $request->employee_id;
                                $ordertasks->priority = 'NORMAL';
                                $ordertasks->tat = $this->getFutureBusinessDay($task_type->tat, $received_date, $holiday_dates_ymd = []);
                                $ordertasks->status = 'CREATED';
                                $ordertasks->received_date = $received_date;
                                $ordertasks->save();

                                $taskhistory = new TaskHistory;
                                $taskhistory->action = 'CREATED';
                                $taskhistory->task_id = $ordertasks->id;
                                $taskhistory->task_status = 'CREATED';
                                $taskhistory->action_by = Auth::id();
                                $taskhistory->candidate_data = '';
                                $taskhistory->antecedants_data = '';
                                $taskhistory->save();
                            }                            
                        }
                    }
                }
            }
        }        

        DB::commit();

        return redirect('orders')->with('success', 'Order created successfully!');
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

        $orders = Order::find($order_id);

        $employers = Employer::where('employers.id', $orders->employer_id)
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employers.id', '=', 'user_pics.employer_id')
            ->select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id','user_pics.photo_url')
            ->first();
        
        $employees = Employee::where('employees.id', $orders->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employees.id', '=', 'user_pics.employee_id')
            ->select('users.*','employees.employee_custom_id','employees.employee_code','employees.id as employee_id','user_pics.photo_url')
            ->first();

        $tasks  = OrderTask::where('order_id', $order_id)->get();

        return view('/orders/orders-details-list', [
            'breadcrumbs' => $breadcrumbs,
            'orders' => $orders,
            'employers' => $employers,
            'employees'      => $employees,
            'tasks'       => $tasks
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
                'name' => "Orders Details"
            ],
            [
                'name' => "Task Details"
            ]
        ];

        $orders = Order::find($order_id);        
        $orderhistories = OrderHistory::where('order_id', $order_id)->get();
        $tasks = OrderTask::find($task_id);
        $taskhistories = TaskHistory::where('task_id', $task_id)->get();        
        $lasthistories = TaskHistory::where('task_id', $task_id)->orderBy('id', 'desc')->first();        
        $employers = Employer::where('employers.id', $orders->employer_id)
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employers.id', '=', 'user_pics.employer_id')
            ->select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id','user_pics.photo_url')
            ->first();        
        
        $employees = Employee::where('employees.id', $orders->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employees.id', '=', 'user_pics.employee_id')
            ->select('users.*','employees.employee_custom_id','employees.employee_code','employees.id as employee_id','user_pics.photo_url')
            ->first();

        $emplPhoto = DB::table('user_pics')->orderBy('id', 'desc')->select('photo_url')->where('employee_id', $employees->employee_id)->first();

        if(isset($emplPhoto->photo_url)){
            $employees->photo_url = $emplPhoto->photo_url;
        }

        $vpdata = DB::table('vp_search_histories')->select('verify_id')->where('order_task_id', $tasks->task_number)->first();

        $userdocs = UserDoc::where('user_id', $employees->id)
            ->where('doc_type_id', 7)
            ->orWhere('user_id', $employees->id)
            ->where('doc_type_id', 1)
            ->orderBy('id', 'desc')
            ->first();

        $taskhistorydocs = TaskHistoryDoc::where(['task_history_id' => $lasthistories->id])->orderBy('id', 'ASC')->get();
        $addresses = UserAddress::where(['employee_id' => $orders->employee_id])->first();

        return view('/orders/task-details', [
            'breadcrumbs' => $breadcrumbs,
            'orders' => $orders,
            'tasks' => $tasks,
            'orderhistories' => $orderhistories,
            'taskhistories' => $taskhistories,
            'employers' => $employers,
            'employees' => $employees,
            'userdocs' => $userdocs,
            'lasthistories' => $lasthistories,
            'taskhistorydocs' => $taskhistorydocs,
            'addresses' => $addresses,
            'vpdata' => $vpdata
        ]);
    }

    public function antecedents_store($order_id, $task_id, Request $request)
    {

        if($request->antecedants_data['severity'] == 'GREEN') {
            $verification_status = 'GREEN';
        } elseif($request->antecedants_data['severity'] == 'YELLOW') {
            $verification_status = 'YELLOW';
        } else {
            $verification_status = 'RED';
        }

        $order = Order::find($order_id);
        $order->status = 'IN_PROGRESS';
        $order->save();

        $taskhistory = new TaskHistory;
        $taskhistory->action = 'UPDATED';
        $taskhistory->task_id = $task_id;
        $taskhistory->task_status = 'COMPLETE';
        $taskhistory->action_by = Auth::id();
        $taskhistory->candidate_data = json_encode($request->candidate_data);
        $taskhistory->antecedants_data = json_encode($request->antecedants_data);
        $taskhistory->severity = $verification_status;
        $taskhistory->severity_conclusion = $request->antecedants_data['conclusion'] ?? '';
        $taskhistory->verification_date = $request->antecedants_data['verification_date'];
        $taskhistory->verified_by = Auth::id();
        $taskhistory->save();

        if($request->document_name){
            foreach ($request->document_name as $key => $doc_name) {
                $taskhistorydoc = new TaskHistoryDoc;
                $taskhistorydoc->task_history_id = $taskhistory->id;
                $taskhistorydoc->document_url = $request->document_url[$key];
                $taskhistorydoc->document_name = $doc_name;
                $taskhistorydoc->save();
            }
        }

        $files = $request->file('attachment');
        
        if($request->hasFile('attachment')){
            foreach ($files as $file) {
                $tempid = rand(10000,99999);
                $s3 = AWS::createClient('s3');
                $fileData = $s3->putObject(array(
                    'Bucket'        => 'cdn.gettruehelp.com',
                    'Key'           => 'reports-files/'.md5($tempid).$file->getClientOriginalName(),
                    'SourceFile'    => $file,
                    'StorageClass'  => 'STANDARD',
                    'ContentType'   => $file->getMimeType(),
                    'ACL'           => 'public-read',
                ));

                if($fileData){
                    $taskhistorydoc = new TaskHistoryDoc;
                    $taskhistorydoc->task_history_id = $taskhistory->id;
                    $taskhistorydoc->document_url = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
                    $taskhistorydoc->document_name = $file->getClientOriginalName();
                    $taskhistorydoc->save();
                }
            }
        }

        if($request->report_print == 'Y'){
            $ordertask = OrderTask::find($task_id);
            $ordertask->status = 'COMPLETE';
            $ordertask->save();
            $this->generate_report($task_id, $taskhistory->id, $request->all());
        } else {
            $ordertask = OrderTask::find($task_id);
            $ordertask->status = 'IN_PROGRESS';
            $ordertask->save();
        }

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
        $employees  = Employee::select('users.*','employees.id as employee_id')
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('employee_employment_history', 'employees.id', '=', 'employee_employment_history.employee_id')
            ->where('employee_employment_history.employed_by', $request->employer_id)
            ->whereNotIn('employees.id',function($query){
               $query->select('employee_id')->from('orders');
            })
            ->get();

        if(!empty($employees)){
            echo '<option value="">Select Employee</option>';
            foreach ($employees as $employee) {
                echo '<option value="'.$employee->employee_id.'">'.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.'</option>';
            }
        } else {
            echo '<option value="">No Employee Found</option>';
        }
    }

    public function get_all_employee(Request $request)
    {
        $employees  = Employee::select('users.*','employees.id as employee_id')
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('employee_employment_history', 'employees.id', '=', 'employee_employment_history.employee_id')
            ->where('employee_employment_history.employed_by', $request->employer_id)
            ->get();

        if(!empty($employees)){
            echo '<option value="">Select Employee</option>';
            foreach ($employees as $employee) {
                echo '<option value="'.$employee->employee_id.'">'.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.'</option>';
            }
        } else {
            echo '<option value="">No Employee Found</option>';
        }
    }

    public function number_of_working_days($from, $to)
    {
        $workingDays = [1, 2, 3, 4, 5];
        $holidayDays = ['*-12-25', '*-01-01', '2020-07-21'];

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

    public function pdf_view_report($task_id, Request $request)
    {
        $tasks = OrderTask::find($task_id);
        $orders = Order::find($tasks->order_id);        
        $orderhistories = OrderHistory::where('order_id', $tasks->order_id)->get();
        $taskhistories = TaskHistory::where('task_id', $task_id)->get();        
        $employers = Employer::where('employers.id', $orders->employer_id)
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employers.id', '=', 'user_pics.employer_id')
            ->select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id','user_pics.photo_url')
            ->first();       
        $employees = Employee::where('employees.id', $orders->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employees.id', '=', 'user_pics.employee_id')
            ->select('users.*','employees.employee_custom_id','employees.employee_code','employees.id as employee_id','user_pics.photo_url')
            ->first();

        $emplPhoto = DB::table('user_pics')->orderBy('id', 'desc')->select('photo_url')->where('employee_id', $employees->employee_id)->first();

        if(isset($emplPhoto->photo_url)){
            $employees->photo_url = $emplPhoto->photo_url;
        }

        $userdocs = UserDoc::where(['user_id' => $employees->id, 'doc_type_id' => 7])->first();
        $lasthistories = TaskHistory::where('task_id', $task_id)->orderBy('id', 'desc')->first(); 
        $taskhistorydocs = TaskHistoryDoc::where(['task_history_id' => $lasthistories->id])->orderBy('id', 'ASC')->get();
        $addresses = UserAddress::where(['employee_id' => $orders->employee_id])->first();
        
        $tasktype = TaskType::where('id', $tasks->task_type)->first();

        $verificationFields = $request->all();

        return PDF::loadView('templates/'.$tasks->task_type, [
            'orders' => $orders,
            'tasks' => $tasks,
            'tasktype' => $tasktype,
            'orderhistories' => $orderhistories,
            'taskhistories' => $taskhistories,
            'employers' => $employers,
            'employees' => $employees,
            'userdocs' => $userdocs,
            'taskhistorydocs' => $taskhistorydocs,
            'verificationFields' => $verificationFields,
            'addresses' => $addresses,
        ])->save(storage_path('reports/'.$task_id.date('-Y-m-d').'.pdf'))->stream($task_id.date('-Y-m-d').'.pdf');
    }

    public function generate_report($task_id, $taskhistory_id, $verificationFields)
    {

        $tasks = OrderTask::find($task_id);
        $orders = Order::find($tasks->order_id);        
        $orderhistories = OrderHistory::where('order_id', $tasks->order_id)->get();
        $taskhistories = TaskHistory::where('task_id', $task_id)->get();        
        $employers = Employer::where('employers.id', $orders->employer_id)
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employers.id', '=', 'user_pics.employer_id')
            ->select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id','user_pics.photo_url')
            ->first();        
        
        $employees = Employee::where('employees.id', $orders->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employees.id', '=', 'user_pics.employee_id')
            ->select('users.*','employees.employee_custom_id','employees.employee_code','employees.id as employee_id','user_pics.photo_url')
            ->first();

        $emplPhoto = DB::table('user_pics')->orderBy('id', 'desc')->select('photo_url')->where('employee_id', $employees->employee_id)->first();

        if(isset($emplPhoto->photo_url)){
            $employees->photo_url = $emplPhoto->photo_url;
        }

        $userdocs = UserDoc::where(['user_id' => $employees->id, 'doc_type_id' => 7])->first();
        $tasktype = TaskType::where('id', $tasks->task_type)->first();
        $lasthistories = TaskHistory::where('task_id', $task_id)->orderBy('id', 'desc')->first(); 
        $taskhistorydocs = TaskHistoryDoc::where(['task_history_id' => $taskhistory_id])->orderBy('id', 'ASC')->get();
        $addresses = UserAddress::where(['employee_id' => $orders->employee_id])->first();

        $pdf = PDF::loadView('/templates/'.$tasks->task_type, [
            'orders' => $orders,
            'tasks' => $tasks,
            'tasktype' => $tasktype,
            'orderhistories' => $orderhistories,
            'taskhistories' => $taskhistories,
            'employers' => $employers,
            'employees' => $employees,
            'userdocs' => $userdocs,
            'lasthistories' => $lasthistories,
            'taskhistorydocs' => $taskhistorydocs,
            'verificationFields' => $verificationFields,
            'addresses' => $addresses,
        ]);

        $employees_name = strtoupper($employees->first_name.'-'.$employees->middle_name.'-'.$employees->last_name);

        $fileName   = $employees_name.'-'.$tasks->task_number.'-'.date('-Y-m-d').'.pdf';

        if( $pdf->save(storage_path('reports/'.$fileName) ) ) {


            $s3 = AWS::createClient('s3');
            $uploadReport = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'img/'.$fileName,
                'SourceFile'    => storage_path('reports/'.$fileName),
                'StorageClass'  => 'STANDARD',
                'ContentType'   => mime_content_type(storage_path('reports/'.$fileName)),
                'ACL'           => 'public-read',
            ));

            if($uploadReport){
                $taskhistory = TaskHistory::find($taskhistory_id);
                $taskhistory->report_url = $uploadReport['ObjectURL'] ? $uploadReport['ObjectURL'] : '';
                $taskhistory->save();

                Storage::delete(storage_path('reports/'.$fileName));
            }
        }
    }

    public function view_report($task_id)
    {
        $lasthistories = TaskHistory::where('task_id', $task_id)->orderBy('id', 'desc')->first();

        return view('/orders/view-report', [
            'report_file'   => $lasthistories->report_url,
        ]);
    }

    public function delete_document($id,$order_id,$task_id){
        TaskHistoryDoc::where('id',$id)->delete();
        return redirect('/orders/task/'.$order_id.'/'.$task_id)->with('success', 'File Deleted successfully!');
    }

    public function generate_postal_otp($task_id){

        $otp = rand(100000,999999);
        $taskhistory = new TaskHistory;
        $taskhistory->action = 'UPDATED';
        $taskhistory->task_id = $task_id;
        $taskhistory->task_status = 'COMPLETE';
        $taskhistory->action_by = Auth::id();
        $taskhistory->candidate_data = '';
        $taskhistory->antecedants_data = json_encode([
            'verification_code' => [
                'name' => 'Postal Verification Code',
                'value' => '',
                'match_status' => '',
                'otp' => $otp,
            ]
        ]);
        $taskhistory->verified_by = Auth::id();
        $taskhistory->save();
        
        $tasks = OrderTask::find($task_id);
        $orders = Order::find($tasks->order_id);              
        $employers = Employer::where('employers.id', $orders->employer_id)
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employers.id', '=', 'user_pics.employer_id')
            ->select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id','user_pics.photo_url')
            ->first();        
        $employees = Employee::where('employees.id', $orders->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employees.id', '=', 'user_pics.employee_id')
            ->select('users.*','employees.employee_custom_id','employees.employee_code','employees.id as employee_id','user_pics.photo_url')
            ->first();

        $addresses = UserAddress::where(['employee_id' => $orders->employee_id])->first();

        $fileName   = $tasks->task_number.'-'.$task_id.date('-Y-m-d').'.pdf';

        return view('templates/generate_postal_otp', [
            'orders' => $orders,
            'tasks' => $tasks,
            'employers' => $employers,
            'employees' => $employees,
            'addresses' => $addresses,
            'otp' => $otp,
        ]);
    }

    public function get_severty(Request $request)
    {
        $severities = TaskTypeSeverity::where([
                'task_type_severities.task_type_id' => $request->task_type_id, 
                'task_type_severities.task_severity' => $request->task_severity
            ])
            ->select('severity_messages.id as severity_id', 'severity_messages.severity_message')
            ->leftJoin('severity_messages', 'task_type_severities.severity_message_id', '=', 'severity_messages.id')
            ->orderBy('task_type_severities.id', 'desc')
            ->get();

        if(!empty($severities)){
            foreach ($severities as $key => $severity) {
            ?>
                <div class="form-group sevrt-div">
                    <label for="<?php echo $severity->task_severity_id; ?>">
                        <input type="radio" name="severity_msg" onchange="get_severty_msg(this)" value="<?php echo $severity->severity_message; ?>" data-id="<?php echo $severity->severity_id; ?>" id="<?php echo $severity->severity_id; ?>"> <?php echo $severity->severity_id.' -- '.$severity->severity_message; ?>
                    </label>
                </div>
            <?php
            }
        }
    }

    public function getFutureBusinessDay($num_business_days, $today_ymd = null, $holiday_dates_ymd = []) {
        $num_business_days = min($num_business_days, 1000);
        $business_day_count = 0;
        $current_timestamp = empty($today_ymd) ? time() : strtotime($today_ymd);
        while ($business_day_count < $num_business_days) {
            $next1WD = strtotime('+1 weekday', $current_timestamp);
            $next1WDDate = date('Y-m-d', $next1WD);        
            if (!in_array($next1WDDate, $holiday_dates_ymd)) {
                $business_day_count++;
            }
            $current_timestamp = $next1WD;
        }
        return date('Y-m-d', $current_timestamp);
    }

    public function generate_digital_messege($task_id){


        $otp = rand(000000,999999);
        $taskhistory = new TaskHistory;
        $taskhistory->action = 'UPDATED';
        $taskhistory->task_id = $task_id;
        $taskhistory->task_status = 'COMPLETE';
        $taskhistory->action_by = Auth::id();
        $taskhistory->candidate_data = '';
        $taskhistory->antecedants_data = json_encode([
            'verification_code' => [
                'name' => 'Postal Verification Code',
                'value' => '',
                'match_status' => '',
                'otp' => $otp,
            ]
        ]);
        $taskhistory->verified_by = Auth::id();
        $taskhistory->save();
        
        $tasks = OrderTask::find($task_id);
        $orders = Order::find($tasks->order_id);              
        $employers = Employer::where('employers.id', $orders->employer_id)
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employers.id', '=', 'user_pics.employer_id')
            ->select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id','user_pics.photo_url')
            ->first();        
        $employees = Employee::where('employees.id', $orders->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('user_pics', 'employees.id', '=', 'user_pics.employee_id')
            ->select('users.*','employees.employee_custom_id','employees.employee_code','employees.id as employee_id','user_pics.photo_url')
            ->first();

        $addresses = UserAddress::where(['employee_id' => $orders->employee_id])->first();
        

        $date = date("Y-m-d H:i:s");
        $url = new Url;
        $url->url = 'truehelp.io/u?c='.md5($task_id);
        $url->code = 'truehelp.io/v?c='.md5($task_id);
        $url->valid_till = date("Y-m-d H:i:s", strtotime($date . " + 5 day"));
        $url->save();

        $SnSclient = new SnsClient([
            'region' => 'us-east-1',
            'version' => '2010-03-31',
            'credentials' => [
            'key' => 'AKIA4SH5KM3GHHQL5CUF',
            'secret' => 'tqp57AghAQCK13orjlYugUHrQ/BecwQrgod/AVfx',
            ]
        ]);

        $SnSclient->publish([
            'Message'     => $url->url.' is your TrueHelp Verification Url. Please update all information correctly.',
            'PhoneNumber' => '+91'.$employees->mobile,
        ]);

        $SnSclient->publish([
            'Message'     => $url->url.' आपका TrueHelp सत्यापन Url है। कृपया सभी जानकारी को सही ढंग से अपडेट करें',
            'PhoneNumber' => '+91'.$employees->mobile,
        ]);

        echo "SUCCESS";
    }

    public function otp($phone, $otp)
    {

        $SnSclient = new SnsClient([
            'region' => 'us-east-1',
            'version' => '2010-03-31',
            'credentials' => [
            'key' => 'AKIA4SH5KM3GHHQL5CUF',
            'secret' => 'tqp57AghAQCK13orjlYugUHrQ/BecwQrgod/AVfx',
            ]
        ]);

        $result = $SnSclient->publish([
            'Message'     => $otp.' is your TrueHelp OTP code. DO NOT share the OTP with ANYONE.',
            'PhoneNumber' => '+91'.$phone,
        ]);

    }

    public function vp($task_number)
    {
        $vpdata = DB::table('vp_search_histories')->where('order_task_id', $task_number)->get();
        $tasks = OrderTask::where('task_number', $task_number)->first();
        $employees = Employee::where('employees.id', $tasks->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->select('users.first_name','users.middle_name','users.last_name','users.co_name')
            ->first();
        $addresses = UserAddress::where(['employee_id' => $tasks->employee_id])->first();

        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Search VP"
            ]
        ];

        return view('orders.vp', [
            'vpdata' => $vpdata,
            'employees' => $employees,
            'addresses' => $addresses,
        ]);
    }

    public function get_address(Request $request)
    {
        $address  = Address::where('employee_id', $request->employee_id)->get();
        ?>
            <div class="col-md-12">
            <p>Addresses <button type="button" onclick="set_dd_val('<?php echo $request->verifications_type ?>')" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalLong" style="float:right;">Add New</button></p>
        <?php 
        if(!empty($address)){
            foreach ($address as $addr) {

                ?>
                    <fieldset id="main_addr">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" id="<?php echo $request->verifications_type ?>_ADDRESS_<?php echo $addr->id ?>" name="<?php echo $request->verifications_type ?>_ADDRESS[]" value="<?php echo $addr->id ?>" />
                        <span class="vs-checkbox">
                        <span class="vs-checkbox--check">
                        <i class="vs-icon feather icon-check"></i>
                        </span>
                        </span>
                        <span class="" style="font-size: 0.85rem;"><?php echo $addr->street_addr1.' '.$addr->street_addr2.' '.$addr->district.' '.$addr->city.' '.$addr->state.' '.$addr->pincode ?></span>
                        </div>
                    </fieldset>
                <?php
            }
        } else {
            echo '<p>No Address Found.</p>';
        }

        echo '</div>';
    }

    public function add_address(Request $request)
    {
        $address = new UserAddress;
        $address->employee_id = $request->employee_id;
        $address->type = $request->type;
        $address->street_addr1 = $request->street_addr1 ?? '';
        $address->street_addr2 = $request->street_addr2 ?? '';
        $address->village = $request->village ?? '';
        $address->post_office = $request->post_office ?? '';
        $address->police_station = $request->police_station ?? '';
        $address->district = $request->district ?? '';
        $address->near_by = $request->near_by ?? '';
        $address->city = $request->city ?? '';
        $address->state = $request->state ?? '';
        $address->pincode = $request->pincode ?? '';
        $address->country = $request->country ?? '';
        if($address->save()){
            echo '<div class="col-md-12">';
            ?>
                <fieldset>
                    <div class="vs-checkbox-con vs-checkbox-primary">
                        <input type="checkbox" id="<?php echo $request->verifications_type ?>_ADDRESS_<?php echo $address->id ?>" name="<?php echo $request->verifications_type ?>_ADDRESS[]" value="<?php echo $address->id ?>" />
                    <span class="vs-checkbox">
                    <span class="vs-checkbox--check">
                    <i class="vs-icon feather icon-check"></i>
                    </span>
                    </span>
                    <span class="" style="font-size: 0.85rem;"><?php echo $address->street_address1.' '.$address->street_address2.' '.$address->village.' '.$address->post_office.' '.$address->police_station.' '.$address->district.' '.$address->city.' '.$address->state.' '.$address->pincode ?></span>
                    </div>
                </fieldset>
            <?php
            echo '</div>';
        } else {
            echo 'FAILED';
        }
        exit;
    }

    public function create_form(Request $request)
    {
        ?>
            <div class="row" style="border-bottom: 1px solid #ccc; padding-top: 15px; position: relative;">
                <span id="close" onclick="remove_div(this)" title="Remove">X</span>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="employer_name">Name of Employer</label>
                        <input type="email" class="form-control" id="employer_name" name="employer_name[]" placeholder="Name of Employer">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="employment_period">Period of Employment</label>
                        <input type="email" class="form-control" id="employment_period" name="employment_period[]" placeholder="Period of Employment">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="designation">Designation</label>
                        <input type="email" class="form-control" id="designation" name="designation[]" placeholder="Designation">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="salary">Last drawn salary by the Applicant (Annual Gross)</label>
                        <input type="email" class="form-control" id="salary" name="salary[]" placeholder="Last drawn salary by the Applicant (Annual Gross)">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="employee_code">Employee Code</label>
                        <input type="email" class="form-control" id="employee_code" name="employee_code[]" placeholder="Employee Code">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="reporting_manager">Reporting Manager's Name</label>
                        <input type="email" class="form-control" id="reporting_manager" name="reporting_manager[]" placeholder="Reporting Manager's Name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="manager_contact">Manager's Contact Details</label>
                        <input type="email" class="form-control" id="manager_contact" name="manager_contact[]" placeholder="Manager's Contact Details">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="hr_name">HR Name</label>
                        <input type="email" class="form-control" id="hr_name" name="hr_name[]" placeholder="HR Name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="hr_email">HR Email</label>
                        <input type="email" class="form-control" id="hr_email" name="hr_email[]" placeholder="HR Email">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="hr_contact_details">HR Contact details</label>
                        <input type="email" class="form-control" id="hr_contact_details" name="hr_contact_details[]" placeholder="HR Contact details">
                    </div>
                </div>
            </div>
        <?php
    }

    public function create_education_form(Request $request)
    {
        $docTypes = DocumentType::all();
        ?>
            <div class="row" style="border-bottom: 1px solid #ccc; padding-top: 15px; position: relative;">
                <span id="close" onclick="remove_div(this)" title="Remove">X</span>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="edu_course_name">Course name</label>
                        <input type="text" class="form-control" id="edu_course_name" name="edu_course_name[]" placeholder="Course Name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="edu_roll_no">Roll/Registration No.</label>
                        <input type="text" class="form-control" id="edu_roll_no" name="edu_roll_no[]" placeholder="Roll No">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="edu_passing_year">Passing Year</label>
                        <input type="text" class="form-control" id="edu_passing_year" name="edu_passing_year[]" placeholder="Passing Year">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="edu_school_name">University/College/School Name</label>
                        <input type="text" class="form-control" id="edu_school_name" name="edu_school_name[]" placeholder="University/College/School Name">
                    </div>
                </div>
                <!-- <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edu_doc_types">Documents Type</label>
                                <select class="form-control" id="edu_doc_types" name="edu_doc_types[]">
                                    <option value="">Select Document</option>
                                    <?php //if($docTypes): ?>
                                        <?php //foreach($docTypes as $docType): ?>
                                            <option value="<?php //echo $docType->id ?>"><?php //echo $docType->name ?></option>
                                        <?php //endforeach; ?>
                                    <?php //endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edu_docs">Related documents</label>
                                <input type="file" class="form-control" id="edu_docs" name="edu_docs[]">
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        <?php
    }

    public function create_form_pan(Request $request)
    {
        ?>
            <div class="row" style="border-bottom: 1px solid #ccc; padding-top: 15px; position: relative;">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pan_dob">DOB</label>
                        <input type="date" class="form-control" id="pan_dob" name="pan_dob" placeholder="DOB of Employer">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pan_no">Pan No</label>
                        <input type="email" class="form-control" id="pan_no" name="pan_no" placeholder="Pan Number">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name_as_per_pan">Name As Per Document</label>
                        <input type="email" class="form-control" id="name_as_per_pan" name="name_as_per_pan" placeholder="Name As Per Document">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pan_file">PAN Card copy</label>
                        <input type="file" class="form-control" id="pan_file" name="pan_file" />
                    </div>
                </div>
            </div>
        <?php
    }

    public function check_aadhar(Request $request)
    {
        $users = Employee::where('employees.id', $request->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->select('users.id')
            ->first();
            echo '<pre>';
            print_r($users);exit;

        if(isset($users) && empty($users->id)){
            $userDoc = UserDoc::where(['user_id' => $users->id, 'doc_type_id' => 1])->first();
            if(isset($userDoc) && !empty($userDoc->id)){
                echo 'EXIST';
            } else {
                echo 'NOT_EXIST';
            }
        } else {
            echo 'NOT_EXIST';
        }
    }

    public function upload_document(Request $request)
    {
        print_r($request->all());
        exit;
        if($request->hasFile('doc_url_front')) {
            $image = $request->file('doc_url_front');
            $filename = $image->getClientOriginalName();
            $tempid = rand(10000,99999);

            $s3 = AWS::createClient('s3');
            $fileData = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'documents/'.md5($tempid).$filename,
                'SourceFile'    => $request->file('doc_url_front'),
                'StorageClass'  => 'STANDARD',
                'ContentType'   => $request->file('doc_url_front')->getMimeType(),
                'ACL'           => 'public-read',
            ));
            
            if($fileData){
                $userdoc = new UserDoc;
                $userdoc->user_id = $user->id;
                $userdoc->doc_type_id = $request->docTypeId;
                $userdoc->cosmos_id = rand(1,9999999);
                $userdoc->doc_number = $request->document_no;
                $userdoc->doc_url = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
                $userdoc->uploaded_by = Auth::id();
                $userdoc->save();
            }
        } 
    }

    public function update_ancedents_field($task_id, Request $request)
    {
        $antecedants_data = array();
        $lastTaskHistory = TaskHistory::where('task_id', $task_id)->orderBy('id', 'desc')->first();
    
        $updates = [
            'reports' => $request->reports,
            'report_details' => [
                'case_id' => $request->case_id,
                'name_found' => $request->name_found,
                'address_found' => $request->address_found,
                'reg_no' => $request->reg_no,
                'court_name' => $request->court_name,
                'stage_of_case' => $request->stage_of_case,
                'fir_no_year' => $request->fir_no_year,
                'police_station' => $request->police_station,
                'act_name' => $request->act_name,
                'section_details' => $request->section_details,
            ],
        ];

        $antecedants_data = json_decode($lastTaskHistory->antecedants_data);

        $antecedants_data->report_data = $updates;

        $taskhistory = new TaskHistory;
        $taskhistory->action = 'UPDATED';
        $taskhistory->task_id = $task_id;
        $taskhistory->task_status = 'COMPLETE';
        $taskhistory->action_by = Auth::id();
        $taskhistory->candidate_data = $lastTaskHistory->candidate_data ?? '';
        $taskhistory->antecedants_data = json_encode($antecedants_data);
        $taskhistory->severity = $lastTaskHistory->severity;
        $taskhistory->severity_conclusion = $lastTaskHistory->severity_conclusion;
        $taskhistory->verification_date = $lastTaskHistory->verification_date;
        $taskhistory->verified_by = Auth::id();
        
        if($taskhistory->save()){
            if($request->reports){

                foreach ($request->reports as $key => $report_file) {
                
                    $atr = '';
                    $str = explode("%URL%", $report_file);

                    Browsershot::url($str[1])
                        ->fullPage()
                        ->setScreenshotType('jpeg', 100)
                        ->save(storage_path('case-files/'.$str[0].'.jpeg'));

                    $s3 = AWS::createClient('s3');
                    $fileData = $s3->putObject(array(
                        'Bucket'        => 'cdn.gettruehelp.com',
                        'Key'           => 'reports-files/'.$str[0].'.jpeg',
                        'SourceFile'    => storage_path('case-files/'.$str[0].'.jpeg'),
                        'StorageClass'  => 'STANDARD',
                        'ContentType'   => 'image/jpeg',
                        'ACL'           => 'public-read',
                    ));

                    if($fileData){
                        $taskhistorydoc = new TaskHistoryDoc;
                        $taskhistorydoc->task_history_id = $taskhistory->id;
                        $taskhistorydoc->document_url = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
                        $taskhistorydoc->document_name = $str[0].'.jpeg';
                        $taskhistorydoc->save();
                    }
                }
            }

            echo 'SUCCESS';
            exit;
        }
        
        echo "FAILED";
        exit;
    }

    public function qc_allocator(Request $request)
    {

        $employers = Employer::select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id')
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->get();

        foreach($employers as $employer){

        }
        
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
            $filter['order_tasks.task_number'] = $request->s;
        } else {
            $s = '';
        }

        if(isset($request->type)){
            $type = $request->type;
            $filter['order_tasks.task_display_id'] = $request->type;
        } else {
            $type = '';
        }

        if(isset($request->status)){
            $status = $request->status;
            $filter['order_tasks.status'] = $request->status;
        } else {
            $status = '';
        }

        if(isset($request->employer_id)){
            $employer_id = $request->employer_id;
            $filter['orders.employer_id'] = $request->employer_id;
        } else {
            $employer_id = '';
        }

        if($request->source){
            $source = $request->source;
            $filter['employers.source_type'] = $request->source;
        } else {
            $source = '';
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

        if($request->emp != ''){
            $orders = DB::table('order_tasks')
                ->leftJoin('orders', 'order_tasks.order_id', '=', 'orders.id')
                ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
                ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
                ->select('order_tasks.*', 'orders.id as orderId', 'employers.employer_custom_id as employer_code', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employer_user.first_name as employer_first_name', 'employer_user.middle_name as employer_middle_name', 'employer_user.last_name as employer_last_name', 'employees.employee_custom_id as employees_code', 'employees_user.first_name as employees_first_name', 'employees_user.middle_name as employees_middle_name', 'employees_user.last_name as employees_last_name')
                ->where($filter)
                ->where('order_tasks.status', '=', 'CREATED')
                ->orWhere('employees_user.first_name', 'like', '%'.$request->emp.'%')
                ->orWhere('employees_user.middle_name', 'like', '%'.$request->emp.'%')
                ->orWhere('employees_user.last_name', 'like', '%'.$request->emp.'%')
                ->orWhere('order_tasks.task_number', 'like', '%'.$request->emp.'%')
                ->groupBy('order_tasks.id')
                ->orderBy('order_tasks.id', 'desc')
                ->paginate($perpage);  
        } else {
            $orders = DB::table('order_tasks')
                ->leftJoin('orders', 'order_tasks.order_id', '=', 'orders.id')
                ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
                ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
                ->select('order_tasks.*', 'orders.id as orderId', 'employers.employer_custom_id as employer_code', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employer_user.first_name as employer_first_name', 'employer_user.middle_name as employer_middle_name', 'employer_user.last_name as employer_last_name', 'employees.employee_custom_id as employees_code', 'employees_user.first_name as employees_first_name', 'employees_user.middle_name as employees_middle_name', 'employees_user.last_name as employees_last_name')
                ->where($filter)
                ->where('order_tasks.status', '=', 'CREATED')
                ->groupBy('order_tasks.id')
                ->orderBy('order_tasks.id', 'desc')
                ->paginate($perpage);
        }

        foreach ($orders as $key => $order) {
            if($order->status == 'COMPLETE'){
                $orders[$key]->tat_days = $this->number_of_working_days($order->received_date, $order->tat);
                if($this->number_of_working_days($order->received_date, $order->tat) > 0){
                    $orders[$key]->tat_color = 'success';
                } else {
                    $orders[$key]->tat_color = 'danger';
                }
            } else {
                $orders[$key]->tat_days = $this->number_of_working_days(date('Y-m-d'), $order->tat);
                if($this->number_of_working_days(date('Y-m-d'), $order->tat) > 0){
                    $orders[$key]->tat_color = 'success';
                } else {
                    $orders[$key]->tat_color = 'danger';
                }
            }
        }

        $employers = Employer::select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id')
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->get();

        return view('orders.allocator', [
            'breadcrumbs' => $breadcrumbs,
            'orders' => $orders,
            'filter' => $filter,
            'perpage' => $perpage,
            's' => $s,
            'source' => $source,
            'type' => $type,
            'status' => $status,
            'employers' => $employers,
            'employer_id' => $employer_id
        ]);
    }
}