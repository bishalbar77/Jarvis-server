<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aws\S3\S3Client; 
use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;
use DB;
use App\Employer;
use App\Uid;
use Geocoder;

class ApiController extends Controller
{
    public function login_otp(Request $request)
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
            
            $employers = Employer::where('phone', $request->phone)->first();

            if(!empty($employers)){
                $otp                = rand(1000, 9999);
                $message            = $otp.' is your TrueHelp OTP code. DO NOT share the OTP with ANYONE.';
                $phone              = '+'.$request->country.$request->phone;
                $employers->id      = $employers->id;
                $employers->otp     = $otp;
                $employers->save();

                $result = $SnSclient->publish([
                    'Message'     => $message,
                    'PhoneNumber' => $phone,
                ]);

                if($result['MessageId']){
                    return response()->json([
                        'response' => [
                            'status'    => 'success',
                            'data'      => "MSG_SENT",
                            'message'   => 'OTP Sent'
                        ]
                    ], 200);
                } else {
                    return response()->json([
                        'response' => [
                            'status'    => 'failed',
                            'data'      => "NOT_SENT",
                            'message'   => $e->getMessage()
                        ]
                    ], 500);
                }        
            } else {
                return response()->json([
                    'response' => [
                        'status'    => 'failed',
                        'data'      => "NOT_SENT",
                        'message'   => $e->getMessage()
                    ]
                ], 500);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'response' => [
                    'status'    => 'failed',
                    'data'      => "NOT_SENT",
                    'message'   => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function registeration_otp(Request $request)
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
            
            $employers = Employer::where('phone', $request->phone)->first();

            if(empty($employers)){
                $otp                = rand(1000, 9999);
                $message            = $otp.' is your TrueHelp OTP code. DO NOT share the OTP with ANYONE.';
                $phone              = '+'.$request->country.$request->phone;

                setcookie('TRUE_HELP_OTP', $otp, time() + (86400 * 30), "/");

                $result = $SnSclient->publish([
                    'Message'     => $message,
                    'PhoneNumber' => $phone,
                ]);

                if($result['MessageId']){
                    return response()->json([
                        'response' => [
                            'status'    => 'success',
                            'data'      => "MSG_SENT",
                            'message'   => 'OTP Sent'
                        ]
                    ], 200);
                } else {
                    return response()->json([
                        'response' => [
                            'status'    => 'failed',
                            'data'      => "NOT_SENT",
                            'message'   => 'Somthing Wrong.'
                        ]
                    ], 500);
                }        
            } else {
                return response()->json([
                    'response' => [
                        'status'    => 'failed',
                        'data'      => "NOT_SENT",
                        'message'   => 'User Already Registered! Please Login.'
                    ]
                ], 500);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'response' => [
                    'status'    => 'failed',
                    'data'      => "NOT_SENT",
                    'message'   => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function files_upload(Request $request)
    {
        try{

            if($request->hasFile('photo')) {
                
                $image          = $request->file('photo');
                $filename       = $image->getClientOriginalName();
                $tempid         = rand(10000,99999);

                $client = S3Client::factory([
                    'version' => 'latest',
                    'region'  => 'ap-south-1',
                    'credentials' => [
                        'key'     => "AKIA4SH5KM3GHHQL5CUF",
                        'secret'  => "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"
                    ]
                ]);

                $result = $client->putObject(array(
                    'Bucket'        => 'cdn.gettruehelp.com',
                    'Key'           => 'img/'.md5($tempid).$filename,
                    'SourceFile'    => $request->file('photo'),
                    'StorageClass'  => 'STANDARD',
                    'ContentType'   => $request->file('photo')->getMimeType(),
                    'ACL'           => 'public-read',
                ));

                if($result){
                    return response()->json([
                        'response' => [
                            'status'    => 'success',
                            'message'   => 'FILE_UPLOADED',
                            'data'      => $result['ObjectURL'] ? $result['ObjectURL'] : '',
                        ]
                    ], 200);
                } else {
                    return response()->json([
                        'response' => [
                            'status'    => 'failed',
                            'message'   => 'FILE_NOT_UPLOADED',
                            'data'      => "",
                        ]
                    ], 500);
                }
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'response' => [
                    'status'    => 'failed',
                    'message'   => 'FILE_NOT_UPLOADED',
                    'data'      => "",
                ]
            ], 500);
        }
    }

    public function uid_store(Request $request)
    {
        request()->validate([
            'uid_type'   => 'required',
            'uid_number' => 'required',
            'uid_data'   => 'required',
        ]);

        $uid = Uid::where('uid_number', $request->uid_number)->first();

        if($uid){
            return response()->json([
                'response' => [
                    'status'    => 'exists',
                    'message'   => 'Already Exists',
                    'data'      => $uid,
                ]
            ], 200);
        }
        
        $result = Uid::create($request->all());
        
        if($result){
            return response()->json([
                'response' => [
                    'status'    => 'success',
                    'message'   => 'inserted',
                    'data'      => $request->all(),
                ]
            ], 200);
        } else {
            return response()->json([
                'response' => [
                    'status'    => 'failed',
                    'message'   => 'Not inserted',
                    'data'      => "",
                ]
            ], 500);
        }
    }

    public function uid_show($uid_number)
    {
        $uid = Uid::where('uid_number', $uid_number)->first();

        if($uid){
            return response()->json([
                'response' => [
                    'status'    => 'success',
                    'message'   => 'Found',
                    'data'      => $uid,
                ]
            ], 200);
        } else {
            return response()->json([
                'response' => [
                    'status'    => 'failed',
                    'message'   => 'Not Found',
                    'data'      => "",
                ]
            ], 500);
        }
    }

    public function uid_list()
    {
        $uid = Uid::all();

        if($uid){
            return response()->json([
                'response' => [
                    'status'    => 'success',
                    'message'   => 'Found',
                    'data'      => $uid,
                ]
            ], 200);
        } else {
            return response()->json([
                'response' => [
                    'status'    => 'failed',
                    'message'   => 'Not Found',
                    'data'      => "",
                ]
            ], 500);
        }
    }

    public function uid_delete($id)
    {
        $uid = Uid::find($id);
        if($uid->delete()){
            return response()->json([
                'response' => [
                    'status'    => 'success',
                    'message'   => 'Deleted Successfully',
                    'data'      => $uid,
                ]
            ], 200);    
        } else {
            return response()->json([
                'response' => [
                    'status'    => 'failed',
                    'message'   => 'Not Exist',
                    'data'      => '',
                ]
            ], 500);
        }
    }

    public function get_address(Request $request)
    {
        request()->validate([
            'latitude'     => 'required',
            'longitude'    => 'required',
        ]);

        $address = Geocoder::getAddressForCoordinates($request->latitude, $request->longitude);

        if($address){
            $count = count($address['address_components']);
            return response()->json([
                'response' => [
                    'status'  => 'success',
                    'message' => 'Found',
                    'data'    => $address['address_components'][$count - 4]->long_name.', '.$address['address_components'][$count - 3]->long_name,
                ]
            ], 200);
        } else {
            return response()->json([
                'response' => [
                    'status'    => 'failed',
                    'message'   => 'Not Found',
                    'data'      => "",
                ]
            ], 500);
        }
    }
}