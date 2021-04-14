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
use App\BillingPlan;


use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;


class EmployerController extends Controller
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
                'name' => "Employers List"
            ]
        ];        

        if(!empty($request->status)){
            $filter = [
                'employers.status' => $request->status
            ];
        }

        if(!empty($request->source)){
            $filter = [
                'employers.source_type' => $request->source
            ];
        }

        

        if($request->s != ''){
            $employers = Employer::where($filter)
                ->where('users.first_name', 'like', '%'.$request->s.'%')
                ->orWhere('users.middle_name', 'like', '%'.$request->s.'%')
                ->orWhere('users.last_name', 'like', '%'.$request->s.'%')
                ->orWhere('employers.b2b_company_name', 'like', '%'.$request->s.'%')
                ->orWhere('employers.b2b_brand_name', 'like', '%'.$request->s.'%')
                ->leftJoin('users', 'employers.user_id', '=', 'users.id')
                ->select('employers.*', 'users.first_name', 'users.middle_name', 'users.last_name')
                ->with('photo')
                ->orderBy('id', 'desc')
                ->paginate($perpage);
        } else {
            $employers = Employer::where($filter)
                ->leftJoin('users', 'employers.user_id', '=', 'users.id')
                ->select('employers.*', 'users.first_name', 'users.middle_name', 'users.last_name')
                ->with('photo')
                ->orderBy('id', 'desc')
                ->paginate($perpage);
        }

        return view('employers.list', [
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
    public function create(Request $request)
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

        $source = $request->source;
        $languages = Language::get();
        $plans = BillingPlan::get();

        return view('employers.create', [
            'breadcrumbs' => $breadcrumbs,
            'languages' => $languages,
            'plans' => $plans,
            'source' => $source
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
        if($request->source_type == 'B2B'){
            $this->validate($request,[
                'email' => 'required',
                'mobile' => 'required',
                'b2b_company_name' => 'required',
                'source_type' => 'required|in:B2B,B2C',
                'status' => 'required|in:I,A',
                'street_addr1' => 'required',
                'city' => 'required',
                'state' => 'required',
                'pincode' => 'required',
            ]);
        } else {
            $this->validate($request,[
                'first_name' => 'required',
                'last_name' => 'required',
                'mobile' => 'required',
                'source_type' => 'required|in:B2B,B2C',
                'status' => 'required|in:I,A',
                'street_addr1' => 'required',
                'city' => 'required',
                'state' => 'required',
                'pincode' => 'required',
            ]);
        }

        DB::beginTransaction();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $userId = '';
        
        if ($request->source_type == 'B2C') {
            $user = new User;
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name ?? '';
            $user->last_name = $request->last_name;
            $user->mobile = $request->mobile;
            $user->save();

            $userId = $user->id;
        }

        $employer = new Employer;
        $employer->employer_custom_id = rand(1000,9999);
        $employer->source_type = $request->source_type;        
        $employer->user_id = $userId;        
        $employer->email = $request->input('email') ?? '';
        $employer->country_code = $request->input('country_code');
        $employer->phone = $request->input('phone') ?? '';
        $employer->mobile = $request->input('mobile');
        $employer->b2b_company_name = $request->input('b2b_company_name');
        $employer->b2b_brand_name = $request->input('b2b_brand_name') ?? '';
        $employer->b2b_gst_no = $request->input('b2b_gst_no') ?? '';
        $employer->b2b_pan_no = $request->input('b2b_pan_no') ?? '';
        $employer->b2b_website = $request->input('b2b_website') ?? '';
        $employer->billing_plan_id = $request->input('billing_plan_id') ?? '';
        $employer->employer_type = $request->input('employer_type') ?? '';
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
        $userpref->employer_id = $employer->id;
        $userpref->lang = $request->input('lang');
        if($request->input('locale')){
            $userpref->locale = $request->input('locale');
        }
        if($request->input('date_pattern')){
            $userpref->date_pattern = $request->input('date_pattern');
        }
        if($request->input('time_format')){
            $userpref->time_format = $request->input('time_format');
        }
        if($request->input('time_zone')){
            $userpref->time_zone = $request->input('time_zone');
        }
        $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
        $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
        $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
        $userpref->save();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::commit();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployerController',
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

        $users = '';

        $plans = BillingPlan::get();
        $employer = Employer::where('id', $id)->with('photo')->first();
        
        if($employer->source_type == 'B2C'){
            $users = User::find($employer->user_id);
        }
        
        $languages = Language::get();
        $userprefs = UserPref::where('employer_id', $employer->id)->first();
        $useraddress = UserAddress::where('employer_id', $employer->id)->first();
        
        return view('employers.edit', [
            'breadcrumbs' => $breadcrumbs,
            'employer'    => $employer,
            'users'       => $users,
            'userprefs'   => $userprefs,
            'languages'   => $languages,
            'useraddress' => $useraddress,
            'plans' => $plans
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
        if($request->source_type == 'B2B'){
            $this->validate($request,[
                'email' => 'required',
                'mobile' => 'required',
                'b2b_company_name' => 'required',
                'source_type' => 'required|in:B2B,B2C',
                'status' => 'required|in:I,A'
            ]);
        } else {
            $this->validate($request,[
                'first_name' => 'required',
                'last_name' => 'required',
                'mobile' => 'required',
                'source_type' => 'required|in:B2B,B2C',
                'status' => 'required|in:I,A'
            ]);
        }

        $employer_old = Employer::where('id', $id)->with('user')->with('photo')->first();

        DB::beginTransaction();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $employer = Employer::find($request->employer_id);
        $employer->source_type = $request->source_type;
        $employer->email = $request->input('email') ?? '';
        $employer->country_code = $request->input('country_code');
        $employer->phone = $request->input('phone') ?? '';
        $employer->mobile = $request->input('mobile');
        $employer->b2b_company_name = $request->input('b2b_company_name') ?? '';
        $employer->b2b_brand_name = $request->input('b2b_brand_name') ?? '';
        $employer->b2b_gst_no = $request->input('b2b_gst_no') ?? '';
        $employer->b2b_pan_no = $request->input('b2b_pan_no') ?? '';
        $employer->b2b_website = $request->input('b2b_website') ?? '';
        $employer->billing_plan_id = $request->input('billing_plan_id');
        $employer->employer_type = $request->input('employer_type') ?? '';
        $employer->status = $request->input('status');
        $employer->save();

        if ($request->source_type == 'B2C') {
            $user = User::find($request->user_id);
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name ?? '';
            $user->last_name = $request->last_name;
            $user->mobile = $request->mobile;
            $user->save();
        }

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
        }

        if($request->userprefs_id != ''){
            $userpref = UserPref::find($request->userprefs_id);
        } else {
            $userpref = new UserPref;
            $userpref->employer_id = $employer->id;
        }

        $userpref->lang = $request->input('lang');

        if($request->input('locale')){
            $userpref->locale = $request->input('locale');
        }
        if($request->input('date_pattern')){
            $userpref->date_pattern = $request->input('date_pattern');
        }
        if($request->input('time_format')){
            $userpref->time_format = $request->input('time_format');
        }
        if($request->input('time_zone')){
            $userpref->time_zone = $request->input('time_zone');
        }
        $userpref->notify_by_sms = $request->input('notify_by_sms') ? 'Y' : 'N';
        $userpref->notify_by_email = $request->input('notify_by_email') ? 'Y' : 'N';
        $userpref->notify_by_wa = $request->input('notify_by_wa') ? 'Y' : 'N';
        $userpref->save();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::commit();

        $logData = json_encode([
            'BY'            => Auth::user()->id,
            'CONTROLLER'    => 'EmployerController',
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
            'CONTROLLER'    => 'EmployerController',
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
            'CONTROLLER'    => 'EmployerController',
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
