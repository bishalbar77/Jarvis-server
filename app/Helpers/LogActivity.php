<?php


namespace App\Helpers;
use Request;
use App\LogActivity as LogActivityModel;
use GeoIP;

class LogActivity
{
    public static function addToLog($post_data, $api_response)
    {
        if(empty($post_data) && empty($api_response)){
            return true;
        }
        
        $log = [];
        $log['subject'] = 'Onclick Route';
        $log['post_data'] = $post_data;
        $log['api_response'] = $api_response;
        if($log['post_data']) {
            $log['subject'] = 'Post data by user';
        }
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : '';
        $arr_ip = geoip()->getLocation(Request::ip());
        $log['current_location'] = '';
        $log['logger_name'] = auth()->check() ? auth()->user()->first_name .' '. auth()->user()->last_name : 'Anonymous' ;
        LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
        return LogActivityModel::latest()->paginate(10);
    }

    public static function logActivityId($id)
    {
        return LogActivityModel::find($id);
    }
}