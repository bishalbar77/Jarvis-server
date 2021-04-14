<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\Employer;
use App\Employee;
use App\SurveyQuestion;
use App\SurveyAnswer;
use Log;
use AWS;
use DB;
use Aws\S3\S3Client; 
use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;
use Auth;

class SurveyController extends Controller
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

        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Surveys"
            ]
        ];

        $employers = Employer::get();

        $filter = [];       

        if($request->status){
            $filter['surveys.survey_status'] = $request->status;
        }

        if($request->employer_id){
            $filter['surveys.employer_id'] = $request->employer_id;
        }
        
        if($request->severity){
            if($request->severity == 'NOT_DONE'){
                $filter['surveys.severity'] = NULL;
            } else {
                $filter['surveys.severity'] = $request->severity;
            }
        }

        if($request->s != ''){
            $surveys = Survey::where($filter)
                ->select('surveys.*', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'users.first_name', 'users.middle_name', 'users.last_name', 'employees.id as employee_id', 'visitors.first_name as vfname', 'visitors.middle_name as vmname', 'visitors.last_name as vlname')
                ->leftJoin('employees', 'surveys.employee_id', '=', 'employees.id')
                ->leftJoin('users', 'employees.user_id', '=', 'users.id')
                ->leftJoin('visitors', 'surveys.visitor_id', '=', 'visitors.id')
                ->leftJoin('employers', 'surveys.employer_id', '=', 'employers.id')
                ->where('users.first_name', 'like', '%'.$request->s.'%')
                ->orWhere('users.middle_name', 'like', '%'.$request->s.'%')
                ->orWhere('users.last_name', 'like', '%'.$request->s.'%')
                ->orderBy('surveys.id', 'desc')->paginate($perpage);
        } else if($request->emp != ''){
            $surveys = Survey::where($filter)
                ->select('surveys.*', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'users.first_name', 'users.middle_name', 'users.last_name', 'employees.id as employee_id', 'visitors.first_name as vfname', 'visitors.middle_name as vmname', 'visitors.last_name as vlname')
                ->leftJoin('employees', 'surveys.employee_id', '=', 'employees.id')
                ->leftJoin('users', 'employees.user_id', '=', 'users.id')
                ->leftJoin('visitors', 'surveys.visitor_id', '=', 'visitors.id')
                ->leftJoin('employers', 'surveys.employer_id', '=', 'employers.id')
                ->where('surveys.employee_id', '=', $request->emp)
                ->orderBy('surveys.id', 'desc')->paginate($perpage);
        } else {
            $surveys = Survey::where($filter)
                ->select('surveys.*', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'users.first_name', 'users.middle_name', 'users.last_name', 'employees.id as employee_id', 'visitors.first_name as vfname', 'visitors.middle_name as vmname', 'visitors.last_name as vlname')
                ->leftJoin('employees', 'surveys.employee_id', '=', 'employees.id')
                ->leftJoin('users', 'employees.user_id', '=', 'users.id')
                ->leftJoin('visitors', 'surveys.visitor_id', '=', 'visitors.id')
                ->leftJoin('employers', 'surveys.employer_id', '=', 'employers.id')
                ->orderBy('surveys.id', 'desc')->paginate($perpage);
        }

        return view('surveys.list', [
            'breadcrumbs' => $breadcrumbs,
            'surveys' => $surveys,
            'employers' => $employers,
            'filter' => $filter,
            'perpage' => $perpage
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
                'link'=>"/surveys",
                'name'=>"Surveys"
            ],
            [
                'name'=>"Create Surveys"
            ]
        ];

        $employers = Employer::get();
        $employees = Employee::select('employees.id','users.first_name', 'users.middle_name', 'users.last_name')
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')->get();
        
        return view('surveys.create', [
            'breadcrumbs' => $breadcrumbs,
            'employers' => $employers,
            'employees' => $employees
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
            'employer_id' => 'required',
            'employee_id' => 'required'
        ]);

        $allResponse = json_encode($request->all());

        $employees = Employee::where('employees.id', $request->employee_id)
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->select('users.first_name','users.middle_name','users.last_name','users.mobile','employees.employee_custom_id','employees.employee_code','employees.id as employee_id')
            ->first();

        $employers = Employer::where('id', $request->employer_id)->first();

        DB::beginTransaction();

        $survey = new Survey;
        $survey->survey_type = 'HEALTH_CHECK';
        $survey->employee_id = $request->employee_id;
        $survey->employer_id = $request->employer_id;
        $survey->save();

        $SnSclient          = new SnsClient([
            'region'        => 'us-east-1',
            'version'       => '2010-03-31',
            'credentials'   => [
            'key'           => 'AKIA4SH5KM3GHHQL5CUF',
            'secret'        => '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',
            ]
        ]);

        $brand = $employers->b2b_brand_name ? ' ('.$employers->b2b_brand_name.')' : '';
        $company = $employers->b2b_company_name.' '.$brand;
        $message = 'Hi '.$employees->first_name.', Health Screening Available from '.$company.'. Please complete the screening before departing for the Day. Have a Nice Day. https://www.gettruehelp.com/healthcheck/?eid='.md5($employees->employee_id);

        $result = $SnSclient->publish([
            'Message'     => $message,
            'PhoneNumber' => '+91'.$employees->mobile,
        ]);

        DB::commit();

        $response = response()->json([
            'response' => [
                'status'    => 200,
                'data'      => '',
                'message'   => 'Order placed successfully'
            ]
        ], 200);

        \LogActivity::addToLog($allResponse, $response);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SeverityController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('surveys')->with('success', 'Survey created successfully!');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/surveys",
                'name'=>"Surveys"
            ],
            [
                'name'=>"Surveys Details"
            ]
        ];

        $surveys = Survey::where('surveys.id', $id)
            ->select('surveys.*', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'users.first_name', 'users.middle_name', 'users.last_name', 'employees.id as employee_id', 'visitors.first_name as vfname', 'visitors.middle_name as vmname', 'visitors.last_name as vlname')
            ->leftJoin('employees', 'surveys.employee_id', '=', 'employees.id')
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('visitors', 'surveys.visitor_id', '=', 'visitors.id')
            ->leftJoin('employers', 'surveys.employer_id', '=', 'employers.id')
            ->orderBy('surveys.id', 'desc')->first();

        $answers = SurveyAnswer::select('survey_answers.question_answer', 'survey_questions.text as question')
            ->leftJoin('survey_questions', 'survey_answers.question_id', '=', 'survey_questions.id')
            ->where('survey_answers.survey_id', $id)
            ->get();
        
        return view('surveys.show', [
            'breadcrumbs' => $breadcrumbs,
            'surveys' => $surveys,
            'answers' => $answers
        ]);
    }

    public function resend(Request $request)
    {
        $surveys = Survey::where('surveys.id', $request->id)
            ->select('surveys.*', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'users.first_name', 'users.middle_name', 'users.last_name', 'users.mobile', 'users.country_code', 'employees.id as employee_id', 'visitors.first_name as vfname', 'visitors.middle_name as vmname', 'visitors.last_name as vlname', 'visitors.mobile as vmobile', 'visitors.country_code as vcountry_code')
            ->leftJoin('employees', 'surveys.employee_id', '=', 'employees.id')
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->leftJoin('visitors', 'surveys.visitor_id', '=', 'visitors.id')
            ->leftJoin('employers', 'surveys.employer_id', '=', 'employers.id')
            ->orderBy('surveys.id', 'desc')->first();

        $SnSclient          = new SnsClient([
            'region'        => 'us-east-1',
            'version'       => '2010-03-31',
            'credentials'   => [
            'key'           => 'AKIA4SH5KM3GHHQL5CUF',
            'secret'        => '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',
            ]
        ]);

        $empname = '';
        $mobile = '';
        if($surveys->visitor_id != ''){
            $empname = $surveys->vfname;
            $mobile = $surveys->vcountry_code.$surveys->vmobile;
        } else {
            $empname = $surveys->first_name;
            $mobile = $surveys->country_code.$surveys->mobile;
        }
        
        $brand = $surveys->b2b_brand_name ? ' ('.$surveys->b2b_brand_name.')' : '';
        $company = $surveys->b2b_company_name.' '.$brand;
        $message = 'Hi '.$empname.', Health Screening Available from '.$company.'. Please complete the screening before departing for the Day. Have a Nice Day. https://www.gettruehelp.com/healthcheck/?eid='.md5($surveys->employee_id);

        $result = $SnSclient->publish([
            'Message'     => $message,
            'PhoneNumber' => '+'.$mobile,
        ]);

        if($result){
            echo 'SUCCESS';
        } else {
            echo 'FAILED';
        }
    }
}
