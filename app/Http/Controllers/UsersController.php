<?php

namespace App\Http\Controllers;
use App\User;
use App\JarvisUser;
use App\DataSource;
use App\UserWebProfile;
use App\Role;
use App\Employer;
use App\Employee;
use App\EmployeeType;
use App\B2bUser;
use App\EmployerEmployeeNetwork;
use App\EmployeeLookupHistory;
use App\UserAddress;
use App\UserPref;
use App\EmployeeEmploymentHistory;
use Auth;
use Illuminate\Support\Facades\DB;
use Log;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\toSql;

class UsersController extends Controller
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
                'name' => "User List"
            ]
        ];    

        $s      = '';
        $source = '';
        $filter = array();
        DB::enableQueryLog();    

        if($request->All()){
            $filter = [
                // 'jarvis_users.status' => $request->status == 'active' ? 'A' : 'I'
            ];
        } else {
            $filter = [];
        }

        if(isset($request->s)){
            $s = $request->s;
            $filter['users.first_name'] = $request->s;
            // $filter['users.middle_name'] = $request->s;
            // $filter['users.last_name'] = $request->s;
        } else {
            $s = '';
        }

        if($request->s != ''){
            $users = User::join('jarvis_users', 'users.id', '=', 'jarvis_users.user_id')
                ->select('users.*','jarvis_users.status')
                ->where('users.first_name', 'like', '%'.$request->s.'%')
                ->orWhere('users.middle_name', 'like', '%'.$request->s.'%')
                ->orWhere('users.last_name', 'like', '%'.$request->s.'%')
                ->orderBy('users.id', 'desc')->get();    
        } else {
            $users = User::where($filter)
            ->join('jarvis_users', 'users.id', '=', 'jarvis_users.user_id')
            ->select('users.*','jarvis_users.status')
            ->where($filter)
            ->orderBy('users.id', 'desc')->get();
        }

        return view('/users/user-list', [
            'breadcrumbs' => $breadcrumbs,
            'users'       => $users,
            'filter'      => $filter
        ]);
    }

    public function b2b(Request $request)
    {
        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "User List"
            ]
        ];        

        if($request->All()){
            $filter = [
                'jarvis_users.status' => $request->status == 'active' ? '1' : '0'
            ];
        } else {
            $filter = [];
        }

        $users = User::where($filter)
            ->join('b2b_users', 'users.id', '=', 'b2b_users.user_id')
            ->select('users.*','b2b_users.status','b2b_users.email as b2b_email')
            ->orderBy('users.id', 'desc')->get();

        return view('/users/b2b-list', [
            'breadcrumbs' => $breadcrumbs,
            'users'       => $users,
            'filter'      => $filter
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
                'link'=>"/users",
                'name'=>"Users"
            ],
            [
                'name'=>"Create User"
            ]
        ];
        
        $users = DB::table("users")->select('*')->whereNotIn('id',function($query) {
            $query->select('user_id')->from('jarvis_users');
        })->get();

        return view('/users/user-create', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function b2b_create()
    {
        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/b2b",
                'name'=>"Users"
            ],
            [
                'name'=>"Create B2B User"
            ]
        ];
        
        $users = DB::table("users")->select('*')->whereNotIn('id',function($query) {
            $query->select('user_id')->from('b2b_users');
        })->get();
        $employers = Employer::where(['source_type' => 'B2B', 'status' => 'A'])->get();
        $employeetypes = EmployeeType::where(array('status' => 'A', 'source' => 'B2B'))->get();

        return view('/users/b2b-create', [
            'breadcrumbs' => $breadcrumbs,
            'employers' => $employers,
            'employeetypes' => $employeetypes,
            'users' => $users,
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required',
            'status' => 'required'
        ]);

        $datasource = new DataSource;
        $datasource->source_name = 'B2C';
        $datasource->campaign_name = '';
        $datasource->ip_address = $request->ip();
        $datasource->save();

        $user = new User;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->country_code = $request->country_code;
        $user->password = Hash::make($request->password);
        $user->data_source_id = $datasource->id;
        $user->save();

        $jarvisuser = new JarvisUser;
        $jarvisuser->user_id = $user->id;
        $jarvisuser->email = $request->email;
        $jarvisuser->password = md5($request->password);
        $jarvisuser->user_id = $user->id;
        $jarvisuser->is_super_admin = 'N';
        $jarvisuser->source = 'B2C';
        $jarvisuser->status = $request->status;
        $jarvisuser->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'UsersController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('users')->with('success', 'User created successfully!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function b2b_store(Request $request)
    {
        if($request->employee_id == 'new'){
            $request->validate([
                'employer_id' => 'required',
                'employee_id' => 'required',
                'employee_type_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users',
                'mobile' => 'required|unique:users',
                'password' => 'required',
                'status' => 'required'
            ]);

            DB::beginTransaction();

            $datasource = new DataSource;
            $datasource->source_name = 'B2B';
            $datasource->campaign_name = 'Jarvis';
            $datasource->ip_address = $request->ip();
            $datasource->save();

            $user = new User;
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->country_code = $request->country_code;
            $user->dob = $request->dob ? date('Y-m-d', strtotime($request->dob)) : '';
            $user->gender = $request->gender;
            $user->data_source_id = $datasource->id;
            $user->save();

            $employee = new Employee;
            $employee->employee_custom_id = rand(1000,9999);
            $employee->employee_type_id = $request->employee_type_id;
            $employee->user_id = $user->id;
            $employee->doj = $request->doj ? date('Y-m-d', strtotime($request->doj)) : date('Y-m-d');
            $employee->save();

            $jarvisuser = new B2bUser;
            $jarvisuser->user_id = $user->id;
            $jarvisuser->email = $request->email;
            $jarvisuser->password = md5($request->password);
            $jarvisuser->status = $request->status;
            $jarvisuser->save();

            $network = new EmployerEmployeeNetwork;
            $network->employer_id = $request->employer_id;
            $network->its_employee = $employee->id;
            $network->status = 'A';
            $network->save();            

            $lookup = new EmployeeLookupHistory;
            $lookup->employee_id = $employee->id;
            $lookup->doc_type_id = $request->docTypeId;
            $lookup->latitude = $request->latitude;
            $lookup->longitude = $request->longitude;
            $lookup->ip_address = $request->ip();
            $lookup->browser_info = $request->header('User-Agent');
            $lookup->lookup_by = $request->employer_id;
            $lookup->save();

            $employmenthistory = new EmployeeEmploymentHistory;
            $employmenthistory->employee_id = $employee->id;
            $employmenthistory->employed_by = $request->employer_id;
            $employmenthistory->salary = $request->salary ?? '';
            $employmenthistory->employment_start = $request->doj ? date('Y-m-d', strtotime($request->doj)) : '';
            $employmenthistory->save();

            $userpref = new UserPref;
            $userpref->user_id = $user->id;
            $userpref->save();

            DB::commit();
        
        } else {

            $request->validate([
                'employer_id' => 'required',
                'employee_id' => 'required',
                'email' => 'required|unique:b2b_users',
                'password' => 'required',
                'status' => 'required'
            ]);

            DB::beginTransaction();

            $jarvisuser = new B2bUser;
            $jarvisuser->user_id = $request->employee_id;
            $jarvisuser->email = $request->email;
            $jarvisuser->password = md5($request->password);
            $jarvisuser->status = $request->status;
            $jarvisuser->save();

            DB::commit();
        }

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'UsersController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        if(isset($jarvisuser->id)){
            return redirect('b2b')->with('success', 'User created successfully!');
        } else {
            DB::rollback();
            return redirect('b2b/create')->with('error', 'Somthing wrong Not Addded!');
        }

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
        $users = User::find($id);
        $roles = Role::all();

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/users",
                'name'=>"Users"
            ],
            [
                'name'=>"Edit User"
            ]
        ];
        
        return view('/users/user-edit', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function b2b_edit($id)
    {
        $users = User::find($id);
        $roles = Role::all();
        $employee = Employee::where('user_id', $id)->first();
        $employmenthistory = EmployeeEmploymentHistory::where('employee_id', $employee->id)->orderBy('updated_at', 'desc')->first();
        $employerdetails = Employer::where('id', $employmenthistory->employed_by)->orderBy('updated_at', 'desc')->first();

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/b2b",
                'name'=>"Users"
            ],
            [
                'name'=>"Edit User"
            ]
        ];

        $employers = Employer::get();
        $employeetypes = EmployeeType::where(array('status' => 'A', 'source' => 'B2B'))->get();
        
        return view('/users/b2b-edit', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users,
            'roles' => $roles,
            'employers' => $employers,
            'employeetypes' => $employeetypes,
            'employerdetails' => $employerdetails,
            'employee' => $employee,
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users'. ($id ? ",id,$id" : ''),
            'mobile' => 'required|unique:users,mobile,'.$id,
            'status' => 'required'
        ]);

        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // exit;

        $user = $usero = User::find($id);
        $user->id = $id;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->country_code = $request->country_code;
        $user->save();

        $jarvisuser = JarvisUser::where('user_id', $user->id)->first();
        $jarvisuser->status = $request->status;
        $jarvisuser->email = $request->email;
        if($request->password):
        $jarvisuser->password = md5($request->password);
        endif;
        $jarvisuser->save();

        if($request->roles){
            $user->assignRole($request->roles);
        }

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'UsersController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => $usero,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/users')->with('success', 'User details Updated successfully!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function b2b_update(Request $request, $id)
    {
        $request->validate([
            'employer_id' => 'required',
            'employee_type_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users'. ($id ? ",id,$id" : ''),
            'mobile' => 'required|unique:users,mobile,'.$id,
            'status' => 'required'
        ]);

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->country_code = $request->country_code;
        $user->gender = $request->gender;
        $user->save();

        $employee = Employee::where('user_id', $id)->first();
        $employee->employee_type_id = $request->employee_type_id;
        $employee->save();

        $jarvisuser = B2bUser::where('user_id', $id)->first();
        $jarvisuser->email = $request->email;
        
        if(!empty($request->password)){
            $jarvisuser->password = md5($request->password);
        }
        
        $jarvisuser->status = $request->status;
        $jarvisuser->save();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'UsersController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('b2b')->with('success', 'User Updated successfully!');
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
        $user = JarvisUser::where('user_id',$id)->first();
        $user->status = ($user->status=='A') ? 'I' : 'A' ;
        $user->save();

        $statusName = $status == '0' ? 'Disabled' : 'Enabled';

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'UsersController',
            'ACTION'        => 'CHANGE_STATUS',
            'OLD_DATA'      => $user,
            'NEW_DATA'      => $statusName,
        ]); 

        Log::critical($logData);

        return redirect('/users')->with('success', 'User status Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'UsersController',
            'ACTION'        => 'DELETED',
            'OLD_DATA'      => $user,
            'NEW_DATA'      => 'Delete',
        ]);

        Log::critical($logData);

        User::destroy($id);

        return redirect('/users')->with('success', 'User deleted successfully!');
    }

    // Account Settings
    public function account_settings(){
        $breadcrumbs = [
            ['link'=>"dashboard-analytics",'name'=>"Home"], ['name'=>"Account Settings"]
        ];
        $user = User::find(Auth::id());
        if(!empty($user->user_web_profile_id)){
            $userweb = UserWebProfile::find($user->user_web_profile_id);
        } else {
            $userweb = '';
        }
        return view('/profile/account-settings', [
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'userweb' => $userweb
        ]);
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'password' => 'min:6|required_with:npassword|same:npassword',
            'npassword' => 'min:6'
        ]);

        $user = $usero = User::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();

        $logData = json_encode([
            'BY'            => Auth::id(),
            'CONTROLLER'    => 'UsersController',
            'ACTION'        => 'UPDATE_PASSWORD',
            'OLD_DATA'      => $usero,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/profile')->with('success', 'User Password Updated successfully!');
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile' => 'required'
        ]);

        $user = $usero = User::find(Auth::id());
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;      
        $user->save();

        $logData = json_encode([
            'BY'            => Auth::id(),
            'CONTROLLER'    => 'UsersController',
            'ACTION'        => 'UPDATE_PROFILE',
            'OLD_DATA'      => $usero,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/profile')->with('success', 'User Profile Updated successfully!');
    }

    public function update_info(Request $request)
    {
        $request->validate([
            'dob' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'co_name' => 'required'
        ]);

        $user = $usero = User::find(Auth::id());
        $user->dob = date('Y-m-d', strtotime($request->dob));
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->co_name = $request->co_name;  
        $user->save();

        $logData = json_encode([
            'BY'            => Auth::id(),
            'CONTROLLER'    => 'UsersController',
            'ACTION'        => 'UPDATE_INFO',
            'OLD_DATA'      => $usero,
            'NEW_DATA'      => $request->all(),
        ]);

        Log::alert($logData);

        return redirect('/profile')->with('success', 'User Profile Info Updated successfully!');
    }

    public function web_profiles(Request $request)
    {
        if(!empty($request->user_web_profile_id)){
            $userwebprofile = $userweb = UserWebProfile::find($request->user_web_profile_id);
            
            $logData = json_encode([
                'BY'            => Auth::id(),
                'CONTROLLER'    => 'UsersController',
                'ACTION'        => 'UPDATE_WEB_PROFILE',
                'OLD_DATA'      => $userweb ?? '',
                'NEW_DATA'      => $request->all(),
            ]);

        } else {
            $userwebprofile = new UserWebProfile;

            $logData = json_encode([
                'BY'            => Auth::id(),
                'CONTROLLER'    => 'UsersController',
                'ACTION'        => 'CREATE_WEB_PROFILE',
                'OLD_DATA'      => $userweb ?? '',
                'NEW_DATA'      => $request->all(),
            ]);
        }

        $userwebprofile->fb_connection_id = $request->fb_connection_id;
        $userwebprofile->li_connection_id = $request->li_connection_id;
        $userwebprofile->twtr_connection_id = $request->twtr_connection_id;  
        $userwebprofile->save();

        $user = User::find(Auth::id());
        $user->user_web_profile_id = $userwebprofile->id;
        $user->save();

        Log::alert($logData);

        return redirect('/profile')->with('success', 'User Profile Info Updated successfully!');
    }
}
