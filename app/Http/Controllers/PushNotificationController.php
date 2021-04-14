<?php

namespace App\Http\Controllers;
use App\VerificationType;
use App\VerificationFields;
use Auth;
use Illuminate\Support\Facades\DB;
use Log;
use AWS;
use OneSignal;

use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        OneSignal::sendNotificationUsingTags(
            "TrueHelp Report Generated",
            array([
                "field"     => "tag",
                "key"       => "userid",
                "relation"  => "=",
                "value"     => "3"
            ]),
            $url = 'https://home.gettruehelp.com/view-report.php?o=4d39626a7376334433336850654857357361647877773d3d', 
            $data = null, 
            $buttons = null,
            $schedule = null
        );
    }
}