<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use App\OrderTask;
use App\Employee;
use App\UserAddress;
use App\TaskHistory;
use App\Section;
use App\Act;
use App\User;
use App\Employer;
use App\Survey;
use DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cosmos(Request $request)
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Search CRC"
            ]
        ];

        $cases = '';

        $acts = Act::all();

        $lastTaskHistory = TaskHistory::where('task_id', $request->task_id)->orderBy('id', 'desc')->first();

        if(!empty($request) && count($request->all()) > 0){

            // echo "<pre>";
            // print_r($request->all());
            // exit;
            // dd($data);
            
            $client = new GuzzleHttp\Client();
            $response = $client->request('POST', 'http://159.65.144.191:8080/crc', ['json' => [
                    "name" => $request->name,
                    "username" => "JARVIS",
                    "token" => "68e508b1-0b55-416e-804f-1d1b0f5534b8",
                    'state_code' => $request->state_code ?? '',
                    'dist_code' => $request->dist_code ?? ''                    
                ]]
            );

            $contents = $response->getBody();
            $data = json_decode($contents);
            
            // echo "<pre>";
            // print_r($data);
            // exit;
            // dd($data);

            if(isset($data->status) && $data->status == '1'){
                $cases = $data->results;
            } else {
                $cases = '';
            }
        }

        return view('searches.cosmos', [
            'breadcrumbs' => $breadcrumbs,
            'cases' => $cases,
            'request' => $request->all(),
            'lastTaskHistory' => $lastTaskHistory,
            'acts' => $acts,
        ]);   
    }

    public function vp(Request $request)
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Search VP"
            ]
        ];

        $cases = '';
        $tasks = OrderTask::where(['task_display_id' => 'CRC'])->select('task_number')->get();

        if(!empty($request) && count($request->all()) > 0){
            
            $client = new GuzzleHttp\Client();
            $response = $client->request('POST', 'https://apiv3.verify24x7.in/crc', ['json' => [
                    "name" => $request->name,
                    "address" => $request->address,
                    "father_name" => $request->father_name ?? '',
                    "batch" => false,
                    "state_name" => $request->state_name ?? '',
                    "user" => "Project 91_API",
                    "auth_token" => "9cO4OY1wpNtquBukOlhQl5grMb07xsT6",               
                ]]
            );

            $contents = $response->getBody();
            $data = json_decode($contents);

            // echo '<pre>';
            // print_r($data);
            // exit;

            if(isset($data) && $data->status == 1){
                $cases = $data->results;

                foreach ($data->results as $key => $val) {
                    DB::table('vp_search_histories')->insert([
                        "order_task_id" => $request->task_id ?? '',
                        "verify_id" => $data->verify_id ?? '',
                        "year" => $val->year ?? '',
                        "subject" => $val->subject ?? '',
                        "address_taluka" => $val->address_taluka ?? '',
                        "source" => $val->source ?? '',
                        "type" => $val->type ?? '',
                        "next_hearing_date" => $val->next_hearing_date ?? '',
                        "address_pincode" => $val->address_pincode ?? '',
                        "first_hearing_date" => $val->first_hearing_date ?? '',
                        "state_name" => $val->state_name ?? '',
                        "address_wc" => $val->address_wc ?? '',
                        "vp_id" => $val->id ?? '',
                        "under_acts" => $val->under_acts ?? '',
                        "address_district" => $val->address_district ?? '',
                        "nature_of_disposal" => $val->nature_of_disposal ?? '',
                        "uniq_case_id" => $val->uniq_case_id ?? '',
                        "name_wc" => $val->name_wc ?? '',
                        "business_category" => $val->business_category ?? '',
                        "filing_no" => $val->filing_no ?? '',
                        "case_category" => $val->case_category ?? '',
                        "address_street" => $val->address_street ?? '',
                        "name" => $val->name ?? '',
                        "dist_code" => $val->dist_code ?? '',
                        "state_code" => $val->state_code ?? '',
                        "link" => $val->link ?? '',
                        "address_state" => $val->address_state ?? '',
                        "court_no_judge" => $val->court_no_judge ?? '',
                        "decision_date" => $val->decision_date ?? '',
                        "court_no_name" => $val->court_no_name ?? '',
                        "under_sections" => $val->under_sections ?? '',
                        "court_name" => $val->court_name ?? '',
                        "case_no_year" => $val->case_no_year ?? '',
                        "address" => $val->address ?? '',
                        "case_code" => $val->case_code ?? '',
                        "dist_name" => $val->dist_name ?? '',
                        "case_type" => $val->case_type ?? '',
                        "police_station" => $val->police_station ?? '',
                        "case_year" => $val->case_year ?? '',
                        "registration_no" => $val->registration_no ?? '',
                        "case_decision_date" => $val->case_decision_date ?? '',
                        "purpose_of_hearing" => $val->purpose_of_hearing ?? '',
                        "case_status" => $val->case_status ?? '',
                        "fir_no" => $val->fir_no ?? '',
                        "md5" => $val->md5 ?? '',
                        "raw_address" => $val->raw_address ?? '',
                        "court_code" => $val->court_code ?? '',
                        "data_category" => $val->data_category ?? '',
                        "global_category" => $val->global_category ?? '',
                        "oparty" => $val->oparty ?? '',
                        "score" => $val->score ?? '',
                        "case_no" => $val->case_no ?? '',
                        "model_score" => $val->model_score ?? '',
                        "order_summary" => $val->order_summary ?? '',
                    ]);
                }
            } else {
                $cases = '';
            }
        }

        return view('searches.vp', [
            'breadcrumbs' => $breadcrumbs,
            'cases' => $cases,
            'request' => $request->all(),
            'tasks' => $tasks
        ]);   
    }

    public function get_candidate_info(Request $request){

        $dataArr = array();
        
        $tasks = OrderTask::where('task_number', $request->task_id)->first();

        $employees = Employee::where('employees.id', $tasks->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->select('users.first_name','users.middle_name','users.last_name', 'users.co_name')
            ->first();

        $addr = UserAddress::where(['employee_id' => $tasks->employee_id])->first();

        $dataArr = array([
            'address' => str_replace('  ', ' ', $addr->street_addr1.' '.$addr->street_addr2.' '.$addr->village.' '.$addr->post_office.' '.$addr->police_station.' '.$addr->district.' '.$addr->near_by.' '.$addr->city.' '.$addr->state.' '.$addr->pincode),
            'name' => str_replace('  ', ' ', $employees->first_name.' '.$employees->middle_name.' '.$employees->last_name),
            'father_name' => $employees->co_name
        ]);

        echo json_encode($dataArr);
        exit;
    }

    public function get_section_by_act($id)
    {
        $sections = Section::where(['act_id' => $id, 'status' => 'A'])->get();

        if($sections){
            foreach ($sections as $key => $section) {
                echo '<option value="'.$section->section_details.'">'.$section->section_details.'<options>';
            }
        } else {
            echo '<option value="">Not Available<options>';
        }
    }

    public function all_modules(Request $request)
    {
        $users = User::join('jarvis_users', 'users.id', '=', 'jarvis_users.user_id')
            ->select('users.*','jarvis_users.status')
            ->where('users.first_name', 'like', '%'.$request->s.'%')
            ->orWhere('users.middle_name', 'like', '%'.$request->s.'%')
            ->orWhere('users.last_name', 'like', '%'.$request->s.'%')
            ->orderBy('users.id', 'desc')->get();

        if(!$users->isEmpty()){
            echo '<li class="d-flex align-items-center"><a href="/users?s='.$request->s.'" class="pb-25"><h6 class="text-primary mb-0">Jarvis User</h6></a></li>';
            foreach($users as $user){
                echo '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="/users/edit/'.$user->id.'">
                    <div class="d-flex justify-content-start align-items-center">
                    <span class="mr-75 undefined" data-icon="undefined"></span>
                    <span>'.$user->first_name.' '.$user->middle_name.' '.$user->last_name.' : in Jarvis User</span></div></a>
                </li>';
            }
        }

        $employees = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->select('users.*','employees.id as employee_id')
            ->where('users.first_name', 'like', '%'.$request->s.'%')
            ->orWhere('users.middle_name', 'like', '%'.$request->s.'%')
            ->orWhere('users.last_name', 'like', '%'.$request->s.'%')
            ->orderBy('users.id', 'desc')->get();

        if(!$employees->isEmpty()){
            echo '<li class="d-flex align-items-center"><a href="/employees?s='.$request->s.'" class="pb-25"><h6 class="text-primary mb-0">Employees</h6></a></li>';
            foreach($employees as $employee){
                echo '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="/employees/edit/'.$employee->employee_id.'?source=B2B">
                    <div class="d-flex justify-content-start align-items-center">
                    <span class="mr-75 undefined" data-icon="undefined"></span>
                    <span>'.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' : in Employees</span></div></a>
                </li>';
            }
        }

        $employers = Employer::leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->select('users.*','employers.id as employer_id','employers.b2b_company_name','employers.b2b_brand_name', 'employers.source_type')
            ->where('users.first_name', 'like', '%'.$request->s.'%')
            ->orWhere('users.middle_name', 'like', '%'.$request->s.'%')
            ->orWhere('users.last_name', 'like', '%'.$request->s.'%')
            ->orWhere('employers.b2b_company_name', 'like', '%'.$request->s.'%')
            ->orWhere('employers.b2b_brand_name', 'like', '%'.$request->s.'%')
            ->orderBy('users.id', 'desc')->get();

        if(!$employers->isEmpty()){
            $name = '';
            echo '<li class="d-flex align-items-center"><a href="/employers?s='.$request->s.'" class="pb-25"><h6 class="text-primary mb-0">Employers</h6></a></li>';
            foreach($employers as $employer){
                
                if($employer->b2b_brand_name != ''){
                    $name = $employer->b2b_company_name.' '.$employer->b2b_brand_name; 
                } elseif($employer->b2b_company_name != ''){
                    $name = $employer->b2b_company_name.' '.$employer->b2b_brand_name; 
                } else {
                    $name = $employer->first_name.' '.$employer->middle_name.' '.$employer->last_name;
                }

                echo '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="/employers/edit/'.$employer->employer_id.'?source='.$employer->source_type.'">
                    <div class="d-flex justify-content-start align-items-center">
                    <span class="mr-75 undefined" data-icon="undefined"></span>
                    <span>'.$name.' : in Employers</span></div></a>
                </li>';
            }
        }

        $orders = DB::table('orders')
            ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
            ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
            ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
            ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
            ->select('orders.id as order_id','employees_user.*','employers.id as employer_id','employers.b2b_company_name','employers.b2b_brand_name', 'employers.source_type')
            ->where('employees_user.first_name', 'like', '%'.$request->s.'%')
            ->orWhere('employees_user.middle_name', 'like', '%'.$request->s.'%')
            ->orWhere('employees_user.last_name', 'like', '%'.$request->s.'%')
            ->orWhere('employers.b2b_company_name', 'like', '%'.$request->s.'%')
            ->orWhere('employers.b2b_brand_name', 'like', '%'.$request->s.'%')
            ->orWhere('orders.order_number', 'like', '%'.$request->s.'%')
            ->orderBy('orders.id', 'desc')->get();

        if(!$orders->isEmpty()){
            $name = '';
            echo '<li class="d-flex align-items-center"><a href="/orders?emp='.$request->s.'" class="pb-25"><h6 class="text-primary mb-0">Orders</h6></a></li>';
            foreach($orders as $order){

                $name = $order->first_name.' '.$order->middle_name.' '.$order->last_name;

                echo '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="/orders/view/'.$order->order_id.'">
                    <div class="d-flex justify-content-start align-items-center">
                    <span class="mr-75 undefined" data-icon="undefined"></span>
                    <span>'.$name.' : in Orders</span></div></a>
                </li>';
            }
        }

        $tasks = DB::table('order_tasks')
            ->leftJoin('orders', 'order_tasks.order_id', '=', 'orders.id')
            ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
            ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
            ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
            ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
            ->select('order_tasks.*', 'orders.id as orderId', 'employers.employer_custom_id as employer_code', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employer_user.first_name as employer_first_name', 'employer_user.middle_name as employer_middle_name', 'employer_user.last_name as employer_last_name', 'employees.employee_custom_id as employees_code', 'employees_user.first_name as employees_first_name', 'employees_user.middle_name as employees_middle_name', 'employees_user.last_name as employees_last_name')
            ->where('employees_user.first_name', 'like', '%'.$request->s.'%')
            ->orWhere('employees_user.middle_name', 'like', '%'.$request->s.'%')
            ->orWhere('employees_user.last_name', 'like', '%'.$request->s.'%')
            ->orWhere('employers.b2b_company_name', 'like', '%'.$request->s.'%')
            ->orWhere('employers.b2b_brand_name', 'like', '%'.$request->s.'%')
            ->orWhere('order_tasks.task_number', 'like', '%'.$request->s.'%')
            ->groupBy('order_tasks.id')
            ->orderBy('order_tasks.id', 'desc')
            ->get();

        if(!$tasks->isEmpty()){
            $name = '';
            echo '<li class="d-flex align-items-center"><a href="/orders/tasks?emp='.$request->s.'" class="pb-25"><h6 class="text-primary mb-0">Tasks</h6></a></li>';
            foreach($tasks as $task){

                $name = $task->employees_first_name.' '.$task->employees_middle_name.' '.$task->employees_last_name;

                echo '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="/orders/task/'.$task->order_id.'/'.$task->id.'">
                    <div class="d-flex justify-content-start align-items-center">
                    <span class="mr-75 undefined" data-icon="undefined"></span>
                    <span>'.$name.'('.$task->task_number.') : in '.$task->task_display_id.' Task</span></div></a>
                </li>';
            }
        }

        $surveys = Survey::select('surveys.*', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'users.first_name', 'users.middle_name', 'users.last_name', 'employees.id as employee_id', 'visitors.first_name as vfname', 'visitors.middle_name as vmname', 'visitors.last_name as vlname')
            ->leftJoin('employees', 'surveys.employee_id', '=', 'employees.id')
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('visitors', 'surveys.visitor_id', '=', 'visitors.id')
            ->leftJoin('employers', 'surveys.employer_id', '=', 'employers.id')
            ->where('users.first_name', 'like', '%'.$request->s.'%')
            ->orWhere('users.middle_name', 'like', '%'.$request->s.'%')
            ->orWhere('users.last_name', 'like', '%'.$request->s.'%')
            ->groupBy('surveys.employee_id')
            ->orderBy('surveys.id', 'desc')->get();

        if(!$surveys->isEmpty()){
            $name = '';
            echo '<li class="d-flex align-items-center"><a href="/surveys?s='.$request->s.'" class="pb-25"><h6 class="text-primary mb-0">Surveys</h6></a></li>';
            foreach($surveys as $survey){

                $name = $survey->first_name.' '.$survey->middle_name.' '.$survey->last_name;

                echo '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="/surveys?emp='.$survey->employee_id.'">
                    <div class="d-flex justify-content-start align-items-center">
                    <span class="mr-75 undefined" data-icon="undefined"></span>
                    <span>'.$name.' : in Surveys</span></div></a>
                </li>';
            }
        }
    }
}