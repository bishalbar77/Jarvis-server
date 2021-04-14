<?php

namespace App\Http\Controllers;
use App\Employee;
use App\Employer;
use App\EmployeeType;
use App\DocumentType;
use App\Address;
use App\UploadedDocument;
use App\VerificationType;
use App\EmployeePictures;
use App\DataSource;
use App\User;
use App\EmployerEmployeeNetwork;
use App\EmployeeLookupHistory;
use App\UserAddress;
use App\UserPref;
use App\EmployeeEmploymentHistory;
use App\UserDoc;
use App\UserPic;
use App\UserWebProfile;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Geocoder;
use Log;
use AWS;
use Aws\S3\S3Client; 
use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;
use Excel;
use App\Imports\EmployeesImport;

use Illuminate\Http\Request;

class EmployeeController extends Controller
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

        $filter = [];

        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Employees List"
            ]
        ];        

        if(!empty($request->employer_id)){
            $filter = [
                'employers.id' => $request->employer_id
            ];
        }

        if(!empty($request->status)){
            $filter = [
                'employees.status' => $request->status == 'active' ? 'A' : 'I'
            ];
        }

        $employers = Employer::select('employers.*','users.first_name','users.middle_name','users.last_name')
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->get();

        if($request->s != ''){
            $employees = Employee::where($filter)
                ->where('employee_user.first_name', 'like', '%'.$request->s.'%')
                ->orWhere('employee_user.middle_name', 'like', '%'.$request->s.'%')
                ->orWhere('employee_user.last_name', 'like', '%'.$request->s.'%')
                ->leftJoin('users as employee_user', 'employees.user_id', '=', 'employee_user.id')
                ->leftJoin('user_pics', 'employees.id', '=', 'user_pics.employee_id')
                ->leftJoin('employee_employment_history', 'employees.id', '=', 'employee_employment_history.employee_id')
                ->leftJoin('employers', 'employee_employment_history.employed_by', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->select('employees.user_id','employees.employee_custom_id', 'user_pics.photo_url', 'employee_user.first_name as empl_first_name', 'employee_user.middle_name as empl_middle_name', 'employee_user.last_name as empl_last_name', 'employee_user.email', 'employee_user.mobile', 'employer_user.first_name as emplo_first_name', 'employer_user.middle_name as emplo_middle_name', 'employer_user.last_name as emplo_last_name', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employers.source_type', 'employees.status', 'employees.updated_at', 'employee_user.id', 'employees.id as employee_id')
                ->orderBy('id', 'desc')
                ->groupBy('employees.id')
                ->paginate($perpage);
        } else {
            $employees = Employee::where($filter)
                ->leftJoin('users as employee_user', 'employees.user_id', '=', 'employee_user.id')
                ->leftJoin('user_pics', 'employees.id', '=', 'user_pics.employee_id')
                ->leftJoin('employee_employment_history', 'employees.id', '=', 'employee_employment_history.employee_id')
                ->leftJoin('employers', 'employee_employment_history.employed_by', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->select('employees.user_id','employees.employee_custom_id', 'user_pics.photo_url', 'employee_user.first_name as empl_first_name', 'employee_user.middle_name as empl_middle_name', 'employee_user.last_name as empl_last_name', 'employee_user.email', 'employee_user.mobile', 'employer_user.first_name as emplo_first_name', 'employer_user.middle_name as emplo_middle_name', 'employer_user.last_name as emplo_last_name', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employers.source_type', 'employees.status', 'employees.updated_at', 'employee_user.id', 'employees.id as employee_id')
                ->orderBy('id', 'desc')
                ->groupBy('employees.id')
                ->paginate($perpage);
        }

        return view('employees.employees-list', [
            'breadcrumbs' => $breadcrumbs,
            'employers'   => $employers,
            'employees'   => $employees,
            'filter'      => $filter,
            's'           => $request->s ?? '',
            'perpage'     => $perpage
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
        $employeetypes      = EmployeeType::where(array('status' => 'A', 'source' => $source))->get();
        $documenttypes      = DocumentType::where(array('status' => 'A', 'source' => $source))->get();
        $verificationtypes  = VerificationType::where(array('status' => 'A', 'source' => $source))->get();

        // echo '<pre>';
        // print_r($employers);
        // exit;

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/employees",
                'name'=>"Employees"
            ],
            [
                'name'=>"Create Employee"
            ]
        ];
        return view('/employees/employees-create', [
            'breadcrumbs' => $breadcrumbs,
            'employers' => $employers,
            'employeetypes' => $employeetypes,
            'documenttypes' => $documenttypes,
            'verificationtypes' => $verificationtypes,
            'source' => $source,
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
            'source_name' => 'required',
            'employer_id' => 'required',
            'employee_type_id' => 'required',
            'dob' => 'required',
            'docTypeId' => 'required',
            'document_no' => 'required',
            'first_name' => 'required',
            'father_name' => 'required',
            'mobile' => 'required',
        ]);

        $otp = rand(1000, 9999);

        DB::beginTransaction();   

        $datasource = new DataSource;
        $datasource->source_name = $request->source_name;
        $datasource->campaign_name = 'Jarvis';
        $datasource->ip_address = $request->ip();
        $datasource->save();

        $user = new User;
        $user->country_code = $request->country_code ?? '91';
        $user->mobile = $this->trim_mobile($request->mobile);
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->alias = $request->alias;
        $user->co_name = $request->father_name;
        $user->dob = $request->dob ? date('Y-m-d', strtotime($request->dob)) : '';
        $user->gender = $request->gender;
        $user->data_source_id = $datasource->id;
        $user->save();

        $employee = new Employee;
        $employee->employee_custom_id = rand(1000,9999);
        $employee->employee_type_id = $request->employee_type_id;
        $employee->employee_code = $request->employee_code ?? '';
        $employee->user_id = $user->id;
        $employee->email = $request->email ?? '';
        $employee->doj = $request->doj ? date('Y-m-d', strtotime($request->doj)) : date('Y-m-d');
        $employee->save();

        $network = new EmployerEmployeeNetwork;
        $network->employer_id = $request->employer_id;
        $network->its_employee = $employee->id;
        $network->status = 'A';
        $network->save();            

        $lookup = new EmployeeLookupHistory;
        $lookup->employee_id = $employee->id;
        $lookup->doc_type_id = $request->docTypeId;
        $lookup->employee_type_id = $request->employee_type_id;        
        $lookup->latitude = $request->latitude;
        $lookup->longitude = $request->longitude;
        $lookup->ip_address = $request->ip();
        $lookup->browser_info = $request->header('User-Agent');
        $lookup->lookup_by = Auth::id();
        $lookup->save();

        $employmenthistory = new EmployeeEmploymentHistory;
        $employmenthistory->employee_id = $employee->id;
        $employmenthistory->employed_by = $request->employer_id;
        $employmenthistory->salary = $request->salary ?? '';
        $employmenthistory->employment_start = $request->doj ? date('Y-m-d', strtotime($request->doj)) : '';
        $employmenthistory->save();


        $userpref = new UserPref;
        $userpref->user_id = $user->id;
        $userpref->lang = $request->input('lang');
        $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
        $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
        $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
        $userpref->save();

        foreach($request->only('doc_url_front') as $key => $files){
            foreach ($files as $file) {
                if(is_file($file)) {
                    $filenameWithExt = $file->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $mimetype = $file->getMimeType();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    $path = $file->move(storage_path('docs'),$fileNameToStore);
                    $client = AWS::createClient('s3');
                    $tempid         = rand(10000,99999);
                    
                    $result = $client->putObject(array(
                        'Bucket'        => 'cdn.gettruehelp.com',
                        'Key'           => 'img/'.md5($tempid).$fileNameToStore,
                        'SourceFile'    => $path,
                        'StorageClass'  => 'STANDARD',
                        'ContentType'   => $mimetype,
                        'ACL'           => 'public-read',
                    ));

                    $userdoc = new UserDoc;
                    $userdoc->user_id = $user->id;
                    $userdoc->doc_type_id = $request->doc_type;
                    $userdoc->doc_number = $request->doc_number;
                    $userdoc->cosmos_id = rand(1,9999999);
                    $userdoc->doc_url = $result['ObjectURL'] . PHP_EOL;
                    $userdoc->uploaded_by = Auth::id();
                    $userdoc->save();                    
                }
            }
        }

        DB::commit();

        $this->store_cosmos_data($request->all());

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployeeController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return Redirect::back()->with('success', 'Employee created successfully!');
    }

    public function store1(Request $request)
    {
        $request->validate([
            'source_name' => 'required',
            'employer_id' => 'required',
            'employee_type_id' => 'required',
            'dob' => 'required',
            'docTypeId' => 'required',
            'document_no' => 'required',
            'first_name' => 'required',
            'father_name' => 'required',
            'mobile' => 'required',
        ]);

        $otp = rand(1000, 9999);

        DB::beginTransaction();   

        $datasource = new DataSource;
        $datasource->source_name = $request->source_name;
        $datasource->campaign_name = 'Jarvis';
        $datasource->ip_address = $request->ip();
        $datasource->save();

        $user = new User;
        $user->country_code = $request->country_code ?? '91';
        $user->mobile = $this->trim_mobile($request->mobile);
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->alias = $request->alias;
        $user->co_name = $request->father_name;
        $user->dob = $request->dob ? date('Y-m-d', strtotime($request->dob)) : '';
        $user->gender = $request->gender;
        $user->data_source_id = $datasource->id;
        $user->save();

        $employee = new Employee;
        $employee->employee_custom_id = rand(1000,9999);
        $employee->employee_type_id = $request->employee_type_id;
        $employee->employee_code = $request->employee_code ?? '';
        $employee->user_id = $user->id;
        $employee->email = $request->email ?? '';
        $employee->doj = $request->doj ? date('Y-m-d', strtotime($request->doj)) : date('Y-m-d');
        $employee->save();

        $network = new EmployerEmployeeNetwork;
        $network->employer_id = $request->employer_id;
        $network->its_employee = $employee->id;
        $network->status = 'A';
        $network->save();            

        $lookup = new EmployeeLookupHistory;
        $lookup->employee_id = $employee->id;
        $lookup->doc_type_id = $request->docTypeId;
        $lookup->employee_type_id = $request->employee_type_id;        
        $lookup->latitude = $request->latitude;
        $lookup->longitude = $request->longitude;
        $lookup->ip_address = $request->ip();
        $lookup->browser_info = $request->header('User-Agent');
        $lookup->lookup_by = Auth::id();
        $lookup->save();

        $employmenthistory = new EmployeeEmploymentHistory;
        $employmenthistory->employee_id = $employee->id;
        $employmenthistory->employed_by = $request->employer_id;
        $employmenthistory->salary = $request->salary ?? '';
        $employmenthistory->employment_start = $request->doj ? date('Y-m-d', strtotime($request->doj)) : '';
        $employmenthistory->save();

        if($request->addr_type != ''){
            $address = new UserAddress;
            $address->employer_id = $request->employer_id;
            $address->employee_id = $employee->id;
            $address->type = $request->addr_type;
            $address->street_addr1 = $request->street_addr1;
            $address->street_addr2 = $request->street_addr2;
            $address->village = $request->village;
            $address->post_office = $request->post_office;
            $address->police_station = $request->police_station;
            $address->district = $request->district ?? '';
            $address->near_by = $request->near_by;
            $address->state = $request->state;
            $address->pincode = $request->pincode;
            $address->country = $request->country;
            $address->stayed_from = $request->stayed_from ?? '';
            $address->stayed_to = $request->stayed_to ?? '';
            $address->save();
        }

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

        if($request->hasFile('doc_url_back')) {
            $image = $request->file('doc_url_back');
            $filename = $image->getClientOriginalName();
            $tempid = rand(10000,99999);

            $s3 = AWS::createClient('s3');
            $fileData = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'documents/'.md5($tempid).$filename,
                'SourceFile'    => $request->file('doc_url_back'),
                'StorageClass'  => 'STANDARD',
                'ContentType'   => $request->file('doc_url_back')->getMimeType(),
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
            
        if($request->photo_url != ''){
            $userpic = new UserPic;
            $userpic->employee_id = $employee->id;
            $userpic->photo_url = $request->photo_url;
            $userpic->uploaded_by = Auth::id();
            $userpic->save();
        }

        $userpref = new UserPref;
        $userpref->user_id = $user->id;
        $userpref->lang = $request->input('lang');
        $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
        $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
        $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
        $userpref->save();

        DB::commit();

        $this->store_cosmos_data($request->all());

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployeeController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('employees')->with('success', 'Employee created successfully!');
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
    public function edit($id, Request $request)
    {
        $source             = $request->source ? $request->source : 'B2B';
        $employers          = Employer::where(array('source_type' => $source))
                                ->leftJoin('users', 'employers.user_id', '=', 'users.id')
                                ->select('employers.id','employers.b2b_company_name','employers.b2b_brand_name','users.first_name','users.middle_name','users.last_name')
                                ->get();
        $employeetypes      = EmployeeType::where(array('status' => 'A', 'source' => $source))->get();
        $documenttypes      = DocumentType::where(array('status' => 'A', 'source' => $source))->get();
        $verificationtypes  = VerificationType::where(array('status' => 'A', 'source' => $source))->get();

        $employee = Employee::find($id);
        $user = User::find($employee->user_id);
        $address = UserAddress::where('employee_id', $id)->get();
        $userpref = UserPref::where('user_id', $employee->user_id)->first();
        $userpics = UserPic::where('employee_id', $id)->get();
        $userdocs = UserDoc::where('user_id', $employee->user_id)
            ->select('user_docs.*', 'document_types.name as doc_name')
            ->leftJoin('document_types', 'user_docs.doc_type_id', '=', 'document_types.id')
            ->orderBy('created_at', 'desc')->get();
        $employmenthistory = EmployeeEmploymentHistory::where('employee_id', $id)->orderBy('updated_at', 'desc')->first();
        $employerdetails = Employer::where('id', $employmenthistory->employed_by)->orderBy('updated_at', 'desc')->first();
        $userwebprofile = UserWebProfile::find($user->user_web_profile_id);

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/employees",
                'name'=>"Employees"
            ],
            [
                'name'=>"Create Employee"
            ]
        ];
        return view('/employees/employees-edit', [
            'breadcrumbs' => $breadcrumbs,
            'employers' => $employers,
            'employeetypes' => $employeetypes,
            'documenttypes' => $documenttypes,
            'verificationtypes' => $verificationtypes,
            'source' => $source,
            'user' => $user,
            'employee' => $employee,
            'address' => $address,
            'userpref' => $userpref,
            'userpics' => $userpics,
            'userdocs' => $userdocs,
            'employmenthistory' => $employmenthistory,
            'employerdetails' => $employerdetails,
            'userwebprofile' => $userwebprofile,
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
            'source_name' => 'required',
            'employer_id' => 'required',
            'employee_type_id' => 'required',
            'dob' => 'required',
            'docTypeId' => 'required',
            'document_no' => 'required',
            'first_name' => 'required',
            'father_name' => 'required',
            'mobile' => 'required',
        ]);

        DB::beginTransaction();

        $employee = Employee::find($id);
        $employee->employee_custom_id = rand(1000,9999);
        $employee->employee_type_id = $request->employee_type_id;
        $employee->employee_code = $request->employee_code ?? '';
        $employee->email = $request->email;
        $employee->doj = $request->doj ? date('Y-m-d', strtotime($request->doj)) : date('Y-m-d');
        $employee->save();

        $user = User::find($request->user_id);
        $user->country_code = $request->country_code ?? '91';
        $user->mobile = $this->trim_mobile($request->mobile);
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->alias = $request->alias;
        $user->co_name = $request->father_name;
        $user->dob = $request->dob ? date('Y-m-d', strtotime($request->dob)) : '';
        $user->gender = $request->gender;
        $user->save();

        if(!empty($request->userpref_id)){
            $userpref = UserPref::find($request->userpref_id);
            $userpref->user_id = $user->id;
            $userpref->lang = $request->input('lang');
            $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
            $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
            $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
            $userpref->save();
        } else {
            $userpref = new UserPref;
            $userpref->user_id = $user->id;
            $userpref->lang = $request->input('lang');
            $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
            $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
            $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
            $userpref->save();
        }

        DB::commit();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployeeController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return Redirect::back()->with('success', 'Employee Update successfully!');
    }

    public function update1(Request $request, $id)
    {
        $request->validate([
            'source_name' => 'required',
            'employer_id' => 'required',
            'employee_type_id' => 'required',
            'dob' => 'required',
            'docTypeId' => 'required',
            'document_no' => 'required',
            'first_name' => 'required',
            'father_name' => 'required',
            'mobile' => 'required',
        ]);

        DB::beginTransaction();

        $employee = Employee::find($id);
        $employee->employee_custom_id = rand(1000,9999);
        $employee->employee_type_id = $request->employee_type_id;
        $employee->employee_code = $request->employee_code ?? '';
        $employee->email = $request->email;
        $employee->doj = $request->doj ? date('Y-m-d', strtotime($request->doj)) : date('Y-m-d');
        $employee->save();

        $user = User::find($request->user_id);
        $user->country_code = $request->country_code ?? '91';
        $user->mobile = $this->trim_mobile($request->mobile);
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->alias = $request->alias;
        $user->co_name = $request->father_name;
        $user->dob = $request->dob ? date('Y-m-d', strtotime($request->dob)) : '';
        $user->gender = $request->gender;
        $user->save();

        $employmenthistory = EmployeeEmploymentHistory::find($request->employmenthistory_id);
        $employmenthistory->employed_by = $request->employer_id;
        $employmenthistory->salary = $request->salary ?? '';
        $employmenthistory->employment_start = $request->doj ? date('Y-m-d', strtotime($request->doj)) : '';
        $employmenthistory->save();

        if($request->address_id != ''){
            $address = UserAddress::find($request->address_id);
            $address->type = $request->addr_type;
            $address->street_addr1 = $request->street_addr1;
            $address->street_addr2 = $request->street_addr2;
            $address->village = $request->village;
            $address->post_office = $request->post_office;
            $address->police_station = $request->police_station;
            $address->district = $request->district;
            $address->near_by = $request->near_by;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->pincode = $request->pincode;
            $address->country = $request->country;
            $address->stayed_from = $request->stayed_from ?? '';
            $address->stayed_to = $request->stayed_to ?? '';
            $address->save();
        } else if($request->addr_type != ''){
            $address = new UserAddress;
            $address->employer_id = $request->employer_id;
            $address->employee_id = $employee->id;
            $address->type = $request->addr_type;
            $address->street_addr1 = $request->street_addr1;
            $address->street_addr2 = $request->street_addr2;
            $address->village = $request->village;
            $address->post_office = $request->post_office;
            $address->police_station = $request->police_station;
            $address->district = $request->district ?? '';
            $address->near_by = $request->near_by;
            $address->state = $request->state;
            $address->pincode = $request->pincode;
            $address->country = $request->country;
            $address->stayed_from = $request->stayed_from ?? '';
            $address->stayed_to = $request->stayed_to ?? '';
            $address->save();
        }

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
                $userdoc->doc_number = $request->document_no;
                $userdoc->cosmos_id = rand(1,9999999);
                $userdoc->doc_url = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
                $userdoc->uploaded_by = Auth::id();
                $userdoc->save();
            }
        }

        if($request->hasFile('doc_url_back')) {
            $image = $request->file('doc_url_back');
            $filename = $image->getClientOriginalName();
            $tempid = rand(10000,99999);

            $s3 = AWS::createClient('s3');
            $fileData = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'documents/'.md5($tempid).$filename,
                'SourceFile'    => $request->file('doc_url_back'),
                'StorageClass'  => 'STANDARD',
                'ContentType'   => $request->file('doc_url_back')->getMimeType(),
                'ACL'           => 'public-read',
            ));
            
            if($fileData){
                $userdoc = new UserDoc;
                $userdoc->user_id = $user->id;
                $userdoc->doc_type_id = $request->docTypeId;
                $userdoc->doc_number = $request->document_no;
                $userdoc->cosmos_id = rand(1,9999999);
                $userdoc->doc_url = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
                $userdoc->uploaded_by = Auth::id();
                $userdoc->save();
            }
        }

        if($request->photo_url != ''){
            $userpic = new UserPic;
            $userpic->employee_id = $employee->id;
            $userpic->photo_url = $request->photo_url;
            $userpic->uploaded_by = Auth::id();
            $userpic->save();
        }

        if(!empty($request->userpref_id)){
            $userpref = UserPref::find($request->userpref_id);
            $userpref->user_id = $user->id;
            $userpref->lang = $request->input('lang');
            $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
            $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
            $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
            $userpref->save();
        } else {
            $userpref = new UserPref;
            $userpref->user_id = $user->id;
            $userpref->lang = $request->input('lang');
            $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
            $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
            $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
            $userpref->save();
        }

        DB::commit();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployeeController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('employees')->with('success', 'Employee Update successfully!');
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

    public function get_work_locations(Request $request)
    {
        $employers = Employer::select('work_locations')->where('id', $request->company_id)->first();

        if($employers->work_locations){
            foreach (explode(',', $employers->work_locations) as $key => $locations) {
                echo '<option value="'.$locations.'">'.$locations.'</option>';
            }
        } else {
            echo '<option value="">Not Available</option>';
        }
    }

    public function get_tags(Request $request)
    {
        $employers = Employer::select('tags')->where('id', $request->company_id)->first();

        if($employers->tags){
            foreach (explode(',', $employers->tags) as $key => $tag) {
                echo '<option value="'.$tag.'">'.$tag.'</option>';
            }
        } else {
            echo '<option value="">No Tags Available</option>';
        }

    }

    private function trim_mobile($mobile){
        
        $mobile = str_replace("+","", $mobile);
        
        $length = strlen($mobile);
        
        if($length == 11){
            $mobile = substr($mobile, 1);
        } elseif($length == 12) {
            $mobile = substr($mobile, 2);                
        } elseif($length == 13) {
            $mobile = substr($mobile, 3);                
        }

        return $mobile;
    }

    public function store_cosmos_data($request)
    {
        $endpoint = "http://159.65.144.191:8080/aadhaars";
        $client = new \GuzzleHttp\Client();

        $response = $client->request('PUT', $endpoint, [
            'json' => [
                "aadhaar_number" => $request['document_no'],
                "first_name" => $request['first_name'],
                "middle_name" => $request['middle_name'],
                "last_name" => $request['last_name'],
                "gender" => $request['gender'],
                "dob" => date('d/m/Y', strtotime($request['dob'])),
                "phone_number" => $request['mobile'],
                "gname" => $request['street_addr1'],
                "house" => $request['street_addr1'],
                "street" => $request['near_by'],
                "loc" => $request['street_addr2'],
                "vtc" => $request['village'],
                "po" => $request['police_station'],
                "dist" => $request['district'],
                "subdist" => $request['city'] ?? '',
                "state" => $request['state'],
                "pincode" => $request['pincode'],
                "username" => "JARVIS",
                "token" => "68e508b1-0b55-416e-804f-1d1b0f5534b8"
            ]
            
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
    }

    public function delete_employee($id)
    {
        $employee = Employee::find($id);
        
        EmployeeEmploymentHistory::where('employee_id', $id)->delete();
        
        EmployerEmployeeNetwork::where('its_employee', $id)->delete();
        
        EmployeeLookupHistory::where('employee_id', $id)->delete();
        
        UserDoc::where('user_id', $employee->user_id)->delete();
        
        UserPic::where('employee_id', $id)->delete();
        
        UserPref::where('user_id', $employee->user_id)->delete();
        
        UserAddress::where('employee_id', $id)->delete();
        
        Employee::where('id', $id)->delete();
        
        $del = User::where('id', $employee->user_id)->delete();

        if($del){
            return redirect('employees')->with('success', 'Employee Deleted successfully!');
        }
        // return redirect('employees')->with('success', 'Employee Deleted successfully!');

    }

    public function upload_profile(Request $request)
    {
        $image_parts = explode(";base64,", $request->image);

        $image_base64 = base64_decode($image_parts[1]);
        
        $file = storage_path('profile/'.uniqid().'.png');

        if(file_put_contents($file, $image_base64)) {
            $s3 = AWS::createClient('s3');
            $fileData = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'img/'.md5(rand(1000000000,999999999999)).'.png',
                'SourceFile'    => $file,
                'StorageClass'  => 'STANDARD',
                'ContentType'   => 'image/png',
                'ACL'           => 'public-read',
            ));            
            
            if($fileData['ObjectURL']){
                $userpic = new UserPic;
                $userpic->employee_id = $request->employee_id;
                $userpic->photo_url = $fileData['ObjectURL'];
                $userpic->uploaded_by = Auth::id();
                $userpic->save();
            }
            echo $fileData['ObjectURL'];
        } else {
            echo 'ERROR';
        }
        exit;    
    }

    public function upload(Request $request)
    {
        $source             = $request->source ? $request->source : 'B2B';
        $employer_id        = $request->employer_id ? $request->employer_id : 0;
        $employers          = Employer::where(array('source_type' => $source))
                                ->leftJoin('users', 'employers.user_id', '=', 'users.id')
                                ->select('employers.id','employers.b2b_company_name','employers.b2b_brand_name','users.first_name','users.middle_name','users.last_name')
                                ->get();

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/employees",
                'name'=>"Employees"
            ],
            [
                'name'=>"Upload Employee"
            ]
        ];
        return view('employees.upload', [
            'breadcrumbs' => $breadcrumbs,
            'employers' => $employers,
            'source' => $source,
            'employer_id' => $employer_id,
        ]);
    }

    public function uploadData($employer_id, $source, Request $request)
    {
        ini_set('memory_limit', '-1');

        $this->validate($request, [
            'xlxs_file'  => 'required|mimes:xls,xlsx'
        ]);

        $importFile = $request->xlxs_file;
        $Import = new EmployeesImport();
        $ts = Excel::import($Import, $importFile);
        // dd($Import->sheetData);
        $Import = $Import->sheetData;
        $data = json_decode(json_encode($Import),true);
        // dd($data);
        // print_r($data);
        // exit;
        return view('employees.verify', compact('data'), [
            'employer_id' => $employer_id,
            'source' => $source,
        ]);
    }

    public function upload_bulk(Request $request)
    {
        // $request->validate([
        //     "email"    => "required|array|min:3",
        //     "email.*"  => "required|string|distinct|min:3",
        //     "email.*"  => "unique:employees,email",
        //     "mobile_number"    => "required|array|min:3",
        //     "mobile_number.*"  => "required|string|distinct|min:3",
        //     "mobile_number.*"  => "unique:users,mobile",
        // ]);

        foreach ($request->employee_types as $key => $value) {

            DB::beginTransaction();   

                $datasource = new DataSource;
                $datasource->source_name = $request->source;
                $datasource->campaign_name = 'Jarvis';
                $datasource->ip_address = $request->ip();
                $datasource->save();

                $user = new User;
                $user->country_code = $request->country_code[$key] ?? '91';
                $user->mobile = $this->trim_mobile($request->mobile_number[$key]);
                $user->first_name = $request->first_name[$key];
                $user->middle_name = $request->middle_name[$key];
                $user->last_name = $request->last_name[$key];
                $user->alias = $request->alias_name[$key] ?? '';
                $user->co_relation = $request->relation[$key];
                $user->co_name = $request->c_o[$key];
                $user->dob = $request->birth_date[$key] ? date('Y-m-d', strtotime($request->birth_date[$key])) : '';
                $user->gender = $request->gender[$key];
                $user->data_source_id = $datasource->id;
                $user->save();

                $employee = new Employee;
                $employee->employee_custom_id = rand(1000,9999);
                $employee->employee_type_id = $this->get_employee_type($request->employee_types[$key], $request->source);
                $employee->employee_code = $request->employee_code[$key] ?? '';
                $employee->user_id = $user->id;
                $employee->email = $request->email[$key] ?? '';
                $employee->doj = $request->doj ? date('Y-m-d', strtotime($request->doj[$key])) : date('Y-m-d');
                $employee->status = 'A';
                $employee->save();

                $network = new EmployerEmployeeNetwork;
                $network->employer_id = $request->employer_id;
                $network->its_employee = $employee->id;
                $network->status = 'A';
                $network->save();            

                $lookup = new EmployeeLookupHistory;
                $lookup->employee_id = $employee->id;
                $lookup->doc_type_id = $this->get_doc_type($request->document_types[$key], $request->source);
                $lookup->employee_type_id = $this->get_employee_type($request->employee_types[$key], $request->source);        
                $lookup->latitude = $request->latitude;
                $lookup->longitude = $request->longitude;
                $lookup->ip_address = $request->ip();
                $lookup->browser_info = $request->header('User-Agent');
                $lookup->lookup_by = Auth::id();
                $lookup->save();

                $employmenthistory = new EmployeeEmploymentHistory;
                $employmenthistory->employee_id = $employee->id;
                $employmenthistory->employed_by = $request->employer_id;
                $employmenthistory->salary = $request->salary[$key] ?? '';
                $employmenthistory->employment_start = $request->joining_date[$key] ? date('Y-m-d', strtotime($request->joining_date[$key])) : '';
                $employmenthistory->save();

                $userdoc = new UserDoc;
                $userdoc->user_id = $user->id;
                $userdoc->doc_type_id = $this->get_doc_type($request->document_types[$key], $request->source);
                $userdoc->doc_number = $request->document_number[$key];
                $userdoc->cosmos_id = rand(1,9999999);
                $userdoc->doc_url = '';
                $userdoc->uploaded_by = Auth::id();
                $userdoc->save();

                $userpref = new UserPref;
                $userpref->user_id = $user->id;
                $userpref->lang = 1;
                $userpref->notify_by_sms = 'Y';
                $userpref->notify_by_email = 'Y';
                $userpref->notify_by_wa = 'Y';
                $userpref->save();

            DB::commit();

            $logData = json_encode([
                'BY'            => Auth::user()->id,
                'CONTROLLER'    => 'EmployeeController',
                'ACTION'        => 'ADD',
                'OLD_DATA'      => '',
                'NEW_DATA'      => $request->all(),
            ]);
            
            Log::info($logData);
        }

        return redirect('employees')->with('success', 'Employee uploaded successfully!');

    }

    public function get_doc_type($doc,$source)
    {
        $docId = '';

        if($source == 'B2B'){
            switch ($doc) {
                case 'AADHAAR':
                    $docId = 1;
                    break;
                case 'PASSPORT':
                    $docId = 2;
                    break;
                case 'DRIVING_LICENCE':
                    $docId = 3;
                    break;
                case 'VOTER_ID':
                    $docId = 4;
                    break;
                case 'PAN_CARD':
                    $docId = 5;
                    break;
                default:
                    $docId = 1;
                    break;
            }
        } else {
            switch ($doc) {
                case 'AADHAAR':
                    $docId = 6;
                    break;
                case 'PASSPORT':
                    $docId = 8;
                    break;
                case 'DRIVING_LICENCE':
                    $docId = 9;
                    break;
                case 'VOTER_ID':
                    $docId = 10;
                    break;
                case 'PAN_CARD':
                    $docId = 7;
                    break;
                default:
                    $docId = 1;
                    break;
            }            
        }
        return $docId;
    }

    public function get_employee_type($emp,$source)
    {
        switch ($emp) {
            case 'DRIVER':
                $type = ($source == 'B2B') ? 12 : 1;
                break;
            case 'COOK':
                $type = ($source == 'B2B') ? 12 : 2;
                break;
            case 'OFFICE_BOY':
                $type = ($source == 'B2B') ? 10 : 3;
                break;
            case 'MAID_FULL_TIME':
                $type = ($source == 'B2B') ? 12 : 4;
                break;
            case 'MAID_PART_TIME':
                $type = ($source == 'B2B') ? 12 : 5;
                break;
            case 'CLEANER':
                $type = ($source == 'B2B') ? 10 : 1;
                break;
            case 'SECURITY_GUARD':
                $type = ($source == 'B2B') ? 11 : 1;
                break;
            case 'MALI_GARDNER':
                $type = ($source == 'B2B') ? 12 : 8;
                break;
            case 'OTHER':
                $type = ($source == 'B2B') ? 19 : 9;
                break;
            case 'SALES_EXECUTIVE':
                $type = ($source == 'B2B') ? 14 : 1;
                break;
            case 'ACCOUNTENT':
                $type = ($source == 'B2B') ? 15 : 1;
                break;
            case 'TECHNICIAN':
                $type = ($source == 'B2B') ? 16 : 1;
                break;
            case 'ADMINISTRATIVE_ASSISTANT':
                $type = ($source == 'B2B') ? 17 : 1;
                break;
            case 'DATA_ENTRY_OPERATOR':
                $type = ($source == 'B2B') ? 18 : 1;
                break;
            case 'ADMINISTRATOR':
                $type = ($source == 'B2B') ? 20 : 1;
                break;
            case 'EXECUTIVE':
                $type = ($source == 'B2B') ? 21 : 1;
                break;
            case 'MANAGER':
                $type = ($source == 'B2B') ? 22 : 1;
                break;
            case 'HR':
                $type = ($source == 'B2B') ? 23 : 1;
                break;
            case 'STUDENT':
                $type = ($source == 'B2B') ? 24 : 1;
                break;
            case 'SKILLED_LABOUR':
                $type = ($source == 'B2B') ? 25 : 1;
                break;
            case 'TEACHER':
                    $type = ($source == 'B2B') ? 30 : 1;
                    break;
            default:
                $type = ($source == 'B2B') ? 12 : 1;
                break;
        }

        return $type;
    }

    public function get_files_fields()
    {
        $documenttypes = DocumentType::where(array('status' => 'A', 'source' => 'B2B'))->get();
        ?>
            <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <select name="doc_type" id="doc_type" class="form-control">
                      <option value="">Select Document Type</option>
                        <?php if($documenttypes) : ?>
                            <?php foreach($documenttypes as $doctype): ?>
                                <option value="<?php echo $doctype->id ?>"><?php echo $doctype->name ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <fieldset class="form-group">
                    <div class="custom-file">
                      <input type="text" name="doc_number[]" class="form-control" placeholder="Number" />
                    </div>
                  </fieldset>
                </div>
                <div class="col-sm-3">
                  <fieldset class="form-group">
                    <div class="custom-file">
                      <input type="file" name="doc_url_front[]" class="custom-file-input" id="doc_url_front" multiple />
                      <label class="custom-file-label" for="doc_url">Choose files</label>
                    </div>
                  </fieldset>
                </div>
                <div class="col-sm-3">
                  <fieldset class="form-group">
                    <button onclick="removeField(this)" class="btn btn-danger glow mb-1 mb-sm-0 mr-0 mr-sm-1" style="padding: 10px 15px;" title="Remove Field" type="button">-</button>
                  </fieldset>
                </div>
            </div>
        <?php
    }

    public function upload_emp_docs($user_id, Request $request)
    {
        try {

        
        foreach($request->only('doc_url_front') as $key => $files){
            foreach ($files as $file) {
                if(is_file($file)) {
                    $filenameWithExt = $file->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $mimetype = $file->getMimeType();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    $path = $file->move(storage_path('docs'),$fileNameToStore);
                    $client = AWS::createClient('s3');
                    $tempid         = rand(10000,99999);
                    
                    $result = $client->putObject(array(
                        'Bucket'        => 'cdn.gettruehelp.com',
                        'Key'           => 'img/'.md5($tempid).$fileNameToStore,
                        'SourceFile'    => $path,
                        'StorageClass'  => 'STANDARD',
                        'ContentType'   => $mimetype,
                        'ACL'           => 'public-read',
                    ));

                    $userdoc = new UserDoc;
                    $userdoc->user_id = $user_id;
                    $userdoc->doc_type_id = $request->doc_type;
                    $userdoc->doc_number = $request->doc_number;
                    $userdoc->cosmos_id = rand(1,9999999);
                    $userdoc->doc_url = $result['ObjectURL'] . PHP_EOL;
                    $userdoc->uploaded_by = Auth::id();
                    $userdoc->save();                    
                }
            }
        }
        
        $userdocms = UserDoc::where('user_id', $user_id)
            ->leftJoin('document_types', 'user_docs.doc_type_id', '=', 'document_types.id')
            ->select('user_docs.*', 'document_types.name as doc_name')
            ->orderBy('user_docs.id', 'desc')
            ->get();

     
        foreach($userdocms as $userdocm){
            echo '<div class="row" id="docs-row-'.$userdocm->id.'">';               
            echo '<div class="col-2"><label>'.$userdocm->doc_name.'</label></div>';
            echo '<div class="col-2"><label>'.$userdocm->doc_number.'</label></div>';
            echo '<div class="col-2"><img src="'.$userdocm->doc_url.'" class="img-fluid" width="40px"></div>';
            echo '<div class="col-sm-3"><fieldset class="form-group">';
            echo '<button onclick="delete_doc('.$userdocm->id.')" type="button" class="btn btn-primary" style="padding: 10px 15px;">Delete</button>';
            echo '</fieldset></div>';
            echo '</div>';
        }
    } catch (Exception $e){
        echo $e->getMessage(); 
        exit;
    }

    }

    public function get_docname($docId)
    {
        $docsType = DocumentType::find($docId);
        
        return $docsType->name;
    }

    public function delete_emp_docs($id)
    {
        if(UserDoc::find($id)->delete()){
            return Redirect::back()->with('success', 'Employee Deleted successfully!');
        }
    }

    public function update_social($id, Request $request)
    {
        if($request->user_web_profile_id == ''){
            $web = New UserWebProfile;
            $web->fb_connection_id = $request->fb_connection_id;
            $web->twtr_connection_id = $request->twtr_connection_id;
            $web->li_connection_id = $request->li_connection_id;
            $web->save();

            $user = User::find($id);
            $user->user_web_profile_id = $web->id;
            $user->save();
        } else {
            $web = UserWebProfile::find($request->user_web_profile_id);
            $web->fb_connection_id = $request->fb_connection_id;
            $web->twtr_connection_id = $request->twtr_connection_id;
            $web->li_connection_id = $request->li_connection_id;
            $web->save();
        }
    }

    public function update_employement($id, Request $request)
    {
        $empHis = new EmployeeEmploymentHistory;
        $empHis->employee_id = $employee->id;
        $empHis->employed_by = $request->employer_id;
        $empHis->salary = $request->salary ?? '';
        $empHis->employment_start = $request->doj ? date('Y-m-d', strtotime($request->doj)) : '';
        $empHis->save();

        return Redirect::back()->with('success', 'Employement Details Updated successfully!');
    }
}