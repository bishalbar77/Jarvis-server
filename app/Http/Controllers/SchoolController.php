<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Log;
use AWS;
use Auth;
use App\Language;
use App\DataSource;
use App\User;
use App\Employer;
use App\UserPic;
use App\UserPref;
use App\UserAddress;


use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;


class SchoolController extends Controller
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
                'name' => "Employers List"
            ]
        ];        

        if(!empty($request->status)){
            $filter = [
                'status' => $request->status == 'active' ? '1' : '0'
            ];
        } else {
            $filter = [];
        }

        $filter = [
            'employer_type' => 'SCHOOL'
        ];

        $employers = Employer::where($filter)->with('user')->with('photo')->orderBy('id', 'desc')->paginate($perpage);

        return view('/employers/employers-list', [
            'breadcrumbs' => $breadcrumbs,
            'employers'   => $employers,
            'filter'      => $filter,
            'perpage'     => $perpage
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
                'link'=>"/employers",
                'name'=>"Employers"
            ],
            [
                'name'=>"Create Employer"
            ]
        ];

        $languages = Language::get();

        return view('/employers/employers-create', [
            'breadcrumbs' => $breadcrumbs,
            'languages' => $languages
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
        $this->validate($request,[
            'mobile' => 'required|unique:users,mobile',
            'email' => 'required|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'source_name' => 'required|in:B2B,B2C',
            'status' => 'required|in:I,A'
        ]);  

        DB::beginTransaction();      

        $datasource = new DataSource;
        $datasource->source_name = $request->input('source_name');
        $datasource->campaign_name = 'Jarvis';
        $datasource->ip_address = $request->ip();
        $datasource->save();

        $user = new User;
        $user->email = $request->input('email');
        $user->email_activation_code = md5($request->email.time());
        $user->password = Hash::make('secret');
        $user->mobile = $this->trim_mobile($request->input('mobile'));
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->dob = date('Y-m-d', strtotime($request->input('dob')));
        $user->gender = $request->input('gender');
        $user->data_source_id = $datasource->id;
        $user->save();

        $employer = new Employer;
        $employer->employer_custom_id = rand(1000,9999);
        $employer->source_type = $request->source_name;
        $employer->user_id = $user->id;
        $employer->email = $request->input('email');
        $employer->email_activation_code = md5($request->email.time());
        $employer->b2b_company_name = $request->input('b2b_company_name');
        $employer->b2b_brand_name = $request->input('b2b_brand_name');
        $employer->b2b_gst_no = $request->input('b2b_gst_no');
        $employer->b2b_pan_no = $request->input('b2b_pan_no');
        $employer->b2b_website = $request->input('b2b_website');
        $employer->status = $request->input('status');
        $employer->save();

        if($request->street_addr1){
            $address = new UserAddress;
            $address->employer_id = $employer->id;
            $address->type = $request->addr_type;
            $address->street_addr1 = $request->street_addr1;
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
            $address->save(); 

            $userAddr = User::find($user->id);
            $userAddr->address_id = $address->id;
            $userAddr->save();
        }

        $userpic = new UserPic;
        $userpic->employer_id = $employer->id;
        $userpic->photo_url = '';    

        if($request->hasFile('photo')) {
            $image          = $request->file('photo');
            $filename       = $image->getClientOriginalName();
            $tempid         = rand(10000,99999);

            $s3 = AWS::createClient('s3');
            $fileData = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'img/'.md5($tempid).$filename,
                'SourceFile'    => $request->file('photo'),
                'StorageClass'  => 'STANDARD',
                'ContentType'   => $request->file('photo')->getMimeType(),
                'ACL'           => 'public-read',
            ));

            if($fileData){
                $userpic->photo_url = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
            }
        }

        $userpic->is_verified = 'Y';
        $userpic->save();

        $userpref = new UserPref;
        $userpref->user_id = $user->id;
        $userpref->lang = $request->input('lang');
        $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
        $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
        $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
        $userpref->save();

        DB::commit();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SchoolController',
            'ACTION'        => 'ADD',
            'OLD_DATA'      => '',
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::info($logData);

        return redirect('employers')->with('success', 'Employer created successfully!');
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

        $breadcrumbs = [
            [
                'link'=>"/",
                'name'=>"Dashboard"
            ],
            [
                'link'=>"/employers",
                'name'=>"Employers"
            ],
            [
                'name'=>"Edit Employer"
            ]
        ];

        $employer = Employer::where('id', $id)->with('user')->with('photo')->first();
        $languages = Language::get();
        $userprefs = UserPref::where('user_id', $employer->user_id)->first();
        $useraddress = UserAddress::where('employer_id', $employer->id)->first();
        
        return view('/employers/employers-edit', [
            'breadcrumbs' => $breadcrumbs,
            'employer'   => $employer,
            'userprefs'   => $userprefs,
            'languages'   => $languages,
            'useraddress' => $useraddress
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
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|unique:users,mobile',
            'email' => 'required|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'source_name' => 'required|in:B2B,B2C',
            'status' => 'required|in:I,A'
        ]);  

        $employer_old = Employer::where('id', $id)->with('user')->with('photo')->first();

        DB::beginTransaction();

        $user = User::find($request->user_id);
        $user->email = $request->input('email');
        $user->email_activation_code = md5($request->email.time());
        $user->password = Hash::make('secret');
        $user->mobile = $this->trim_mobile($request->input('mobile'));
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->dob = date('Y-m-d', strtotime($request->input('dob')));
        $user->gender = $request->input('gender');
        $user->save();

        $employer = Employer::find($request->employer_id);
        $employer->employer_custom_id = rand(1000,9999);
        $employer->source_type = $request->source_name;
        $employer->email = $request->input('email');
        $employer->email_activation_code = md5($request->email.time());
        $employer->b2b_company_name = $request->input('b2b_company_name');
        $employer->b2b_brand_name = $request->input('b2b_brand_name');
        $employer->b2b_gst_no = $request->input('b2b_gst_no');
        $employer->b2b_pan_no = $request->input('b2b_pan_no');
        $employer->b2b_website = $request->input('b2b_website');
        $employer->status = $request->input('status');
        $employer->save();

        if($request->hasFile('photo')) {
            $image          = $request->file('photo');
            $filename       = $image->getClientOriginalName();
            $tempid         = rand(10000,99999);

            $s3 = AWS::createClient('s3');
            $fileData = $s3->putObject(array(
                'Bucket'        => 'cdn.gettruehelp.com',
                'Key'           => 'img/'.md5($tempid).$filename,
                'SourceFile'    => $request->file('photo'),
                'StorageClass'  => 'STANDARD',
                'ContentType'   => $request->file('photo')->getMimeType(),
                'ACL'           => 'public-read',
            ));

            if($fileData){
                $userpic = UserPic::find($request->userpic_id);
                $userpic->photo_url = $fileData['ObjectURL'] ? $fileData['ObjectURL'] : '';
                $userpic->is_verified = 'Y';
                $userpic->save();
            }
        }

        $userpref = UserPref::find($request->userprefs_id);
        $userpref->lang = $request->input('lang');
        $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
        $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
        $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
        $userpref->save();

        if(!empty($request->useraddress_id)){
            $address = UserAddress::find($request->useraddress_id);
            $address->type = $request->addr_type;
            $address->street_addr1 = $request->street_addr1;
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
            $address->save();
        } elseif($request->street_addr1){
            $address = new UserAddress;
            $address->employer_id = $employer->id;
            $address->type = $request->addr_type;
            $address->street_addr1 = $request->street_addr1;
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
            $address->save(); 

            $userAddr = User::find($user->id);
            $userAddr->address_id = $address->id;
            $userAddr->save();
        }

        DB::commit();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SchoolController',
            'ACTION'        => 'UPDATE',
            'OLD_DATA'      => $employer_old,
            'NEW_DATA'      => $request->all(),
        ]);
        
        Log::alert($logData);

        return redirect('employers')->with('success', 'Employer created successfully!');
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
        $employer = Employer::find($id);
        $employer->id = $id;
        $employer->status = $status;
        $employer->save();

        $statusName = $status == '0' ? 'Disabled' : 'Enabled';

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SchoolController',
            'ACTION'        => 'CHANGE_STATUS',
            'OLD_DATA'      => $employer,
            'NEW_DATA'      => $statusName,
        ]); 

        Log::critical($logData);

        return redirect('/employers')->with('success', 'Employer status Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employer = Employer::find($id);

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'SchoolController',
            'ACTION'        => 'DELETED',
            'OLD_DATA'      => $employer,
            'NEW_DATA'      => 'Delete',
        ]);

        Log::critical($logData);

        $employer->delete();

        return redirect('/employers')->with('success', 'Employer deleted successfully!');
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
}
