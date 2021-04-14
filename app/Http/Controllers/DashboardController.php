<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderTask;
use App\Employee;
use App\Employer;
use App\Order;
use App\BillingPlan;
use App\EmployeeEmploymentHistory;
use App\Survey;
use DB;
use AWS;
use Aws\S3\S3Client; 
use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;
use Mail;
use App\Mail\TestAmazonSes;
use Spatie\Browsershot\Browsershot;

class DashboardController extends Controller
{
    // Dashboard - Analytics
    public function dashboardAnalytics(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $employers = Employer::count();
        $employees = Employee::count();
        $orders = Order::count();
        $created = OrderTask::where('status', 'CREATED')->count();
        $inprogress = OrderTask::where('status', 'IN_PROGRESS')->count();
        $complete = OrderTask::where('status', 'COMPLETE')->count();

        return view('/pages/dashboard-analytics', [
            'pageConfigs' => $pageConfigs,
            'employers' => $employers,
            'employees' => $employees,
            'orders' => $orders,
            'created' => $created,
            'inprogress' => $inprogress,
            'complete' => $complete,
        ]);
    }

    // Dashboard - Ecommerce
    public function dashboardEcommerce(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/dashboard-ecommerce', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function test_fun()
    {

    $python = `python /var/www/html/gettruehelp/python/hello.py`;
    echo '<pre>';
    print_r(json_encode($python));
    exit;


        $result = shell_exec("\var\www\html\gettruehelp\python\hello.py");

        echo '<pre>';
        print_r($result);
        exit;

        // DB::enableQueryLog();

        $surveys = Survey::where(DB::raw("DATE(created_at)"), '2020-10-07')->where('survey_status', 'DRAFT')->get();
        // $surveys = Survey::where(DB::raw("DATE(created_at) = '".date('Y-m-d')."'"))->where('survey_status', 'DRAFT')->get();

        foreach ($surveys as $key => $survey) {
            $employer = Employer::find($survey->employer_id);
            $employee = Employee::where('employees.id', $survey->employee_id)
                            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
                            ->select('users.first_name','users.middle_name','users.last_name','users.country_code','users.mobile','employees.employee_custom_id','employees.employee_code','employees.id as employee_id')
                            ->first();

                            // print_r($employee);
            
            if($employee->mobile == '8750961363'){

                $SnSclient = new SnsClient([
                    'region' => 'us-east-1',
                    'version' => '2010-03-31',
                    'credentials' => [
                    'key' => 'AKIA4SH5KM3GHHQL5CUF',
                    'secret' => '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',
                    ]
                ]);

                $brand = $employer->b2b_brand_name ? ' ('.$employer->b2b_brand_name.')' : '';
                $company = $employer->b2b_company_name.' '.$brand;
                $message = 'Hi '.$employee->first_name.', Health Screening Available from '.$company.'. Please complete the screening before departing for the Day. Have a Nice Day. https://www.gettruehelp.com/healthcheck/?eid='.md5($employee->employee_id);

                $result = $SnSclient->publish([
                    'Message'     => $message,
                    'PhoneNumber' => '+'.$employee->country_code.$employee->mobile,
                ]);
            }
        }
        exit;

        // dd(DB::getQueryLog());
        echo '<pre>';
        print_r($surveys);
        exit;

Browsershot::url('https://njdg.ecourts.gov.in/njdgv1/civil/o_civil_case_history_es.php?es_flag=&captchaValid=valid&case_no=&filing_number=&case_number=218900002912017&cino=JHJR030005412017&state_code=7&dist_code=11&court_code=2&type=both&objection1=totalpending_cases&matchtotal=13145&jocode=XX0001&court_no=1')
    ->fullPage()
    ->setScreenshotType('jpeg', 100)
    ->save(storage_path('case-files/jalaj.jpeg'));

    exit;

        Mail::to('jalajmishra06@gmail.com')->send(new TestAmazonSes());

        exit;


        echo date('H:i:s');
        exit;
        if(0==0){
            $plans = BillingPlan::whereRaw("FIND_IN_SET('SELF_HEALTHCHECK',billing_verification_tasks)")
            ->where('status', 'A')
            ->select('id')
            ->get();

            if($plans){
                
                foreach ($plans as $key => $plan) {
                    
                    $employers = Employer::where('billing_plan_id', $plan->id)->get();
                    
                    if($employers){
                        
                        foreach ($employers as $key => $employer) {
                            
                            $empHistory = EmployeeEmploymentHistory::where('employed_by', $employer->id)->orderBy('updated_at', 'desc')->get();
                            
                            if($empHistory){
                                
                                foreach ($empHistory as $key => $empHis) {
                                    
                                    $employees = Employee::where('employees.id', $empHis->employee_id)
                                        ->leftJoin('users', 'employees.user_id', '=', 'users.id')
                                        ->leftJoin('user_prefs', 'employees.id', '=', 'user_prefs.employee_id')
                                        ->select('users.first_name','users.middle_name','users.last_name','users.country_code','users.mobile','employees.employee_custom_id','employees.employee_code','employees.id as employee_id')
                                        ->where('user_prefs.time_zone', '=', 'Asia/Kolkata')
                                        ->where('employees.status', '=', 'A')
                                        ->get();
                                    
                                    foreach ($employees as $key => $employee) {
                                        
                                        $survey = new Survey;
                                        $survey->survey_type = 'HEALTH_CHECK';
                                        $survey->employee_id = $employee->employee_id;
                                        $survey->employer_id = $employer->id;
                                        $survey->save();

                                        // if($employee->mobile == '8750961363'){

                                            $SnSclient          = new SnsClient([
                                                'region'        => 'us-east-1',
                                                'version'       => '2010-03-31',
                                                'credentials'   => [
                                                'key'           => 'AKIA4SH5KM3GHHQL5CUF',
                                                'secret'        => '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',
                                                ]
                                            ]);

                                            $brand = $employer->b2b_brand_name ? ' ('.$employer->b2b_brand_name.')' : '';
                                            $company = $employer->b2b_company_name.' '.$brand;
                                            $message = 'Hi '.$employee->first_name.', Health Screening Available from '.$company.'. Please complete the screening before departing for the Day. Have a Nice Day. https://www.gettruehelp.com/healthcheck/?eid='.md5($employee->employee_id);

                                            $result = $SnSclient->publish([
                                                'Message'     => $message,
                                                'PhoneNumber' => '+'.$employee->country_code.$employee->mobile,
                                            ]);
                                        // }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //$this->otp();  
    }
}

