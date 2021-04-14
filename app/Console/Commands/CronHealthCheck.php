<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use AWS;
use Aws\S3\S3Client; 
use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;
use App\BillingPlan;
use App\EmployeeEmploymentHistory;
use App\Survey;
use App\Employee;
use App\Employer;
use DB;

class CronHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:healthcheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Health Check Survey';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
                                        // ->where('user_prefs.time_zone', '=', 'Asia/Kolkata')
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
                                                'region'        => 'ap-south-1',
                                                'version'       => '2010-03-31',
                                                'credentials'   => [
                                                'key'           => 'AKIA4SH5KM3GOZGMNHLP',
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

    public function otp()
    {
        try{

            $SnSclient          = new SnsClient([
                'region'        => 'us-east-1',
                'version'       => '2010-03-31',
                'credentials'   => [
                'key'           => 'AKIA4SH5KM3GHHQL5CUF',
                'secret'        => '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',
                ]
            ]);

            $result = $SnSclient->publish([
                'Message'     => 'Crone Job Messege',
                'PhoneNumber' => '+918750961363',
            ]);

            return response()->json([
                'response' => [
                    'status'    => 200,
                    'data'      => '',
                    'message'   => 'OTP Sent to Registered Number.',
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'response' => [
                    'status'    => '500',
                    'data'      => "",
                    'message'   => $e->getMessage()
                ]
            ], 500);
        }
    }
}
