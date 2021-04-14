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

class CronHealthCheckReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:healthcheckreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Health Check Survey Reminder';

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
        $surveys = Survey::where(DB::raw("DATE(created_at)"), date('Y-m-d'))->where('survey_status', 'DRAFT')->get();

        foreach ($surveys as $key => $survey) {
            $employer = Employer::find($survey->employer_id);
            $employee = Employee::where('employees.id', $survey->employee_id)
                            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
                            ->select('users.first_name','users.middle_name','users.last_name','users.country_code','users.mobile','employees.employee_custom_id','employees.employee_code','employees.id as employee_id')
                            ->first();

            // if($employee->mobile == '8750961363'){

                $SnSclient = new SnsClient([
                    'region' => 'ap-south-1',
                    'version' => '2010-03-31',
                    'credentials' => [
                    'key' => 'AKIA4SH5KM3GOZGMNHLP',
                    'secret' => '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',
                    ]
                ]);

                $brand = $employer->b2b_brand_name ? ' ('.$employer->b2b_brand_name.')' : '';
                $company = $employer->b2b_company_name.' '.$brand;
                $message = 'REMINDER: Hi '.$employee->first_name.', Health Screening Available from '.$company.'. Please complete the screening before departing for the Day. Have a Nice Day. https://www.gettruehelp.com/healthcheck/?eid='.md5($employee->employee_id);

                $result = $SnSclient->publish([
                    'Message'     => $message,
                    'PhoneNumber' => '+'.$employee->country_code.$employee->mobile,
                ]);
            // }
        }
    }
}
