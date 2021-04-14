<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\TaskHistory;
use App\Employer;
use App\Address;
use DateInterval;
use DatePeriod;
use DateTime;
use App\User;
use DB;

class ClientBillingController extends Controller
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

        $s      = '';
        $source = '';
        $filter = array();
        $start_date = '';
        $end_date = '';

        if(isset($request->s)){
            $s = $request->s;
            $filter['order_tasks.task_number'] = $request->s;
        } else {
            $s = '';
        }

        if(isset($request->type)){
            $type = $request->type;
            $filter['order_tasks.task_display_id'] = $request->type;
        } else {
            $type = '';
        }

        if(isset($request->status)){
            $status = $request->status;
            $filter['order_tasks.status'] = $request->status;
        } else {
            $status = '';
        }

        if(isset($request->employer_id)){
            $employer_id = $request->employer_id;
            $filter['orders.employer_id'] = $request->employer_id;
        } else {
            $employer_id = '';
        }

        if($request->source){
            $source = $request->source;
            $filter['employers.source_type'] = $request->source;
        } else {
            $source = '';
        }

        if(isset($request->start_date)){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
        } else {
            $start_date = '';
        }

        $breadcrumbs  = [
            [
                'link' => "/",
                'name' => "Dashboard"
            ],
            [
                'name' => "Billing List"
            ]
        ];

        DB::enableQueryLog();


        if(isset($request->start_date) && $request->start_date != ''){
            $orders = DB::table('order_tasks')
                ->leftJoin('orders', 'order_tasks.order_id', '=', 'orders.id')
                ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
                ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
                ->leftJoin('user_addresses as addr', 'employees.id', '=', 'addr.employee_id')
                ->leftJoin('task_history', 'order_tasks.id', '=', 'task_history.task_id')
                ->select('order_tasks.*', 'orders.id as orderId', 'employers.employer_custom_id as employer_code', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employer_user.first_name as employer_first_name', 'employer_user.middle_name as employer_middle_name', 'employer_user.last_name as employer_last_name', 'employees.employee_custom_id as employees_code', 'employees_user.first_name as employees_first_name', 'employees_user.middle_name as employees_middle_name', 'employees_user.last_name as employees_last_name', 'addr.city as user_city', 'addr.state as user_state', 'task_history.verification_date')
                ->where($filter)
                ->whereDate('order_tasks.received_date', '<=', $end->format('Y-m-d H:i:s'))
                ->whereDate('order_tasks.received_date', '>=', $start->format('Y-m-d H:i:s'))
                ->groupBy('order_tasks.id')
                ->orderBy('order_tasks.id', 'desc')
                ->paginate($perpage); 
        } else {
            $orders = DB::table('order_tasks')
                ->leftJoin('orders', 'order_tasks.order_id', '=', 'orders.id')
                ->leftJoin('employers', 'orders.employer_id', '=', 'employers.id')
                ->leftJoin('users as employer_user', 'employers.user_id', '=', 'employer_user.id')
                ->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')
                ->leftJoin('users as employees_user', 'employees.user_id', '=', 'employees_user.id')
                ->leftJoin('user_addresses as addr', 'employees.id', '=', 'addr.employee_id')
                ->leftJoin('task_history', 'order_tasks.id', '=', 'task_history.task_id')
                ->select('order_tasks.*', 'orders.id as orderId', 'employers.employer_custom_id as employer_code', 'employers.b2b_company_name', 'employers.b2b_brand_name', 'employer_user.first_name as employer_first_name', 'employer_user.middle_name as employer_middle_name', 'employer_user.last_name as employer_last_name', 'employees.employee_custom_id as employees_code', 'employees_user.first_name as employees_first_name', 'employees_user.middle_name as employees_middle_name', 'employees_user.last_name as employees_last_name', 'addr.city as user_city', 'addr.state as user_state', 'task_history.verification_date')
                ->where($filter)
                ->groupBy('order_tasks.id')
                ->orderBy('order_tasks.id', 'desc')
                ->paginate($perpage);
        }      
        
        // dd(DB::getQueryLog());

        foreach ($orders as $key => $order) {
            $lasthistories = TaskHistory::where('task_id', $order->id)->orderBy('id', 'desc')->first();
            $orders[$key]->verification_date = $lasthistories->verification_date ?? '';
        }

        $employers = Employer::select('users.*','employers.employer_custom_id','employers.b2b_company_name','employers.b2b_brand_name','employers.id as employer_id')
            ->leftJoin('users', 'employers.user_id', '=', 'users.id')
            ->get();

        return view('billing.clients', [
            'breadcrumbs' => $breadcrumbs,
            'orders' => $orders,
            'filter' => $filter,
            'perpage' => $perpage,
            's' => $s,
            'source' => $source,
            'type' => $type,
            'status' => $status,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'employers' => $employers,
            'employer_id' => $employer_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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

    public function number_of_working_days($from, $to)
    {
        $workingDays = [1, 2, 3, 4, 5];
        $holidayDays = ['*-12-25', '*-01-01', '2020-07-21'];

        $from = new DateTime($from);
        $to = new DateTime($to);
        $to->modify('+1 day');
        $interval = new DateInterval('P1D');
        $periods = new DatePeriod($from, $interval, $to);

        $days = 0;
        foreach ($periods as $period) {
            if (!in_array($period->format('N'), $workingDays)) continue;
            if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
            if (in_array($period->format('*-m-d'), $holidayDays)) continue;
            $days++;
        }
        return $days;
    }
}
