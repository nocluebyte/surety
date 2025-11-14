<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
// use App\Models\Setting;
use App\Models\Year;
 use App\Models\Location;
// use App\Models\QualityCheck;
use Carbon\Carbon;
use Sentinel;
use View;
use DB;
use AppHelper;
use Session;
use Config;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;


// use Imagick;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected $user;

    public function __construct($arguments = null)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Sentinel::getUser();
            if ($this->user != null) {
                $this->role = $this->user->roles->first();
                $this->current_user_role =  $this->role->slug;
                view()->share('current_user', $this->user);
                view()->share('current_user_name', $this->user->first_name . ' ' . $this->user->last_name);
            }
            if ($this->user != null) {
                $current_time = Carbon::now();
                $last_login = Carbon::parse($this->user->last_login);
                $this->now = $current_time;
                if ($last_login->diffInSeconds($current_time) <= 10) {
                    $dataTableBuilders[] = "DataTables_dataTableBuilder_/production-planning/new-index";
                    $dataTableBuilders[] = "DataTables_dataTableBuilder_/raw-production-planning";
                    $dataTableBuilders[] = "DataTables_dataTableBuilder_/purchase_order";
                    $dataTableBuilders[] = "DataTables_dataTableBuilder_/quotation_rawmaterial";
                    $dataTableBuilders[] = "DataTables_dataTableBuilder_/quotation_new";
                    $dataTableBuilders[] = "DataTables_dataTableBuilder_/pos";
                    view()->share('dataTableBuilders', $dataTableBuilders);
                }
                // $user_location_id = null;
                // if(!Session::has('user_location_id')){
                //     $user_location_id = $this->user->location_id;
                //     Session::put('user_location_id',$user_location_id);
                // } else {
                //     $user_location_id = Session::get('user_location_id');
                // }
                // // $user_location = Location::find($user_location_id);
                // // $user_location_name = $user_location ? $user_location->name : '';
                // // if(!Session::has('user_location_name')){
                // //     Session::put('user_location_name',$user_location_name);
                // // } else {
                // //     $user_location_name = Session::get('user_location_name');
                // // }

                $year = Year::where('is_default', 'Yes')->first(); 
                if (!empty($year)) {
                    $fromDate = date('y', strtotime($year->from_date));
                    $toDate = date('y', strtotime($year->to_date));
                    $default_year_name = $fromDate.'-'.$toDate;
                } else {
                    $default_year_name = '';
                }

                if(!Session::has('default_year_name')){
                    Session::put('default_year_name',$default_year_name);
                } else {
                    $default_year_name = Session::get('default_year_name');
                }

                // view()->share('user_location_id', $user_location_id);
                // view()->share('user_location_name', $user_location_name); 
                view()->share('default_year_name', $default_year_name); 
            }
            return $next($request);
        });
        view()->share('theme', 'app');
        if (request()->input('download', false)) {
            View::share('theme', 'limitless.ajax');
        }
        $form_submit_seconds = Config::get('srtpl.settings.form_submit_seconds',5);
        // Setting::where('name', 'form_submit_seconds')->pluck('value')->first()
        View::share('form_submit_seconds', $form_submit_seconds);
        /*
        $all_year = Year::select('*')->get();
        $default_year = $all_year->where('is_default', 'yes')->first();
        $all_year = $all_year->pluck('year','id')->toArray();
        if(!Session::has('default_year')){
            Session::put('default_year',$default_year);
        }
        */
        // view()->share('default_year', $default_year);
        $months =  ["1"=>"January", "February", "March", "April",
                    "May", "June", "July", "August",
                    "September", "October", "November", "December"
                    ];
        $today = Carbon::now();
        $today->useMonthsOverflow(false);
        $yestarday = Carbon::now()->subDay('1');
        $currMonth = $today->format('m');
        $currMonthName = $today->format('F');
        $currYear = $today->format('Y');
        $day_range = [];
        // this month will from date [first day of month], to date [last day of month]
        $from_date = new Carbon('first day of '.$currMonthName.' '.$currYear);
        $to_date = new Carbon('last day of '.$currMonthName.' '.$currYear);
        $from_date->useMonthsOverflow(false);
        $to_date->useMonthsOverflow(false);
        $first_day_of_month = $from_date->format('d-m-Y');
        $last_day_of_month = $today->format('d-m-Y');
        $day_range['this_month'] = ['from_date'=>$first_day_of_month, 'to_date'=>$last_day_of_month];

        // last month will from date [first day of month-1month], to date [last day of month1month]
        $lastMonth = $currMonth;
        $lastYear = $currYear;
        if($currMonth > 1){
            $lastMonth = $currMonth -1;
        }else{
            $lastMonth = 12;
            $lastYear = $currYear - 1;
        }
        $lastMonthName = $months[$lastMonth];
        $last_month_from_date = new Carbon('first day of '.$lastMonthName.' '.$lastYear);
        $last_month_to_date = new Carbon('last day of '.$lastMonthName.' '.$lastYear);


        $last_month_first_day = $last_month_from_date->format('d-m-Y');
        $last_month_last_day = $last_month_to_date->format('d-m-Y');
        $day_range['last_month'] = ['from_date'=>$last_month_first_day,'to_date'=>$last_month_last_day];

        // last 3 month
        $lastMonthName = $months[$lastMonth];
        $last_month_from_date = new Carbon('first day of '.$lastMonthName.' '.$lastYear);
        $last_month_to_date = new Carbon('last day of '.$lastMonthName.' '.$lastYear);
        $last_3_month_from_date = $from_date->subMonth(3)->format('d-m-Y');
        $last_3_month_to_date = $last_month_to_date->format('d-m-Y');
        $day_range['last_3_month'] = ['from_date'=>$last_3_month_from_date,'to_date'=>$last_3_month_to_date];

        // this week will from date [first day of week], to date [last day of week] Wednesday as last day
        $today->startOfWeek(Carbon::THURSDAY);
        $today->endOfWeek(Carbon::WEDNESDAY);
        $week = clone $today;
        $thisWeekFromDate = $week->startOfWeek(Carbon::THURSDAY)->format('d-m-Y');
        $thisWeekToDate = $week->endOfWeek(Carbon::THURSDAY)->format('d-m-Y');
        $day_range['this_week'] = ['from_date'=>$thisWeekFromDate,'to_date'=>$thisWeekToDate];

        // last week will from date [first day of week-1week], to date [last day of week-1week] Wednesday as last day
        $lastWeek = clone $today;
        $last_week = $lastWeek->subWeek(1);
        $lastWeekFromDate = $last_week->startOfWeek(Carbon::THURSDAY)->format('d-m-Y');
        $lastWeekToDate = $last_week->endOfWeek(Carbon::THURSDAY)->format('d-m-Y');

        // this year will be from date[current year finacial date], to date [current year finacial end date]
        /*
        $current_year = Session::get('default_year');
        $prev_year = Year::where('id','<', $current_year->id)->orderBy('id', 'desc')->first();
        $day_range['last_week'] = ['from_date'=>$lastWeekFromDate,'to_date'=>$lastWeekToDate];
        $day_range['this_year'] = ['from_date'=>$current_year->from_date,'to_date'=>$current_year->to_date];
        if($prev_year){
            $day_range['prev_year'] = ['from_date'=>$prev_year->from_date,'to_date'=>$prev_year->to_date];
        }
        */
        // half year
        $todayFormat = $today->format('d-m-Y');
        /*
        $currYearStartDate = Carbon::parse($current_year->from_date);
        $currYearStartDateYear = $currYearStartDate->format('Y');
        if($currMonth >= 10 || $currMonth <= 3){
            $firstDayHalfYear = new Carbon('first day October '.$currYearStartDateYear);
            $day_range['half_year'] = ['from_date'=>$firstDayHalfYear->format('d-m-Y'),'to_date'=>$todayFormat];
        }else{
            $day_range['half_year'] = ['from_date'=>$current_year->from_date,'to_date'=>$todayFormat];
        }
        */

        // today will be from and to date will be current date

        $day_range['today'] = ['from_date'=>$todayFormat,'to_date'=>$todayFormat];

        // yestarday will be from yesterday date, to date=yesterday date
        $day_range['yestarday'] = ['from_date'=>$yestarday->format('d-m-Y'),'to_date'=>$yestarday->format('d-m-Y')];
        view()->share('day_range', $day_range);

        // view()->share('all_year', $all_year);

        // Location Code
        // $all_locations = Location::where('status', 'Active')->pluck('name','id')->toArray();
        // view()->share('all_locations', $all_locations);

        // $rmQC = QualityCheck::select()->where('type','RawMaterial')->where('form_type', 'Main')->first();
        // view()->share('rmQC', $rmQC);

        // AppHelper::setDefaultImage('uploads/default/default.jpg');
        DB::connection()->enableQueryLog();
        setlocale(LC_MONETARY, 'en_IN');

        // Remove wkhtmltopdf-0-12-5 as wkhtml updated to 0-12-6
        $qc_routes = [
            'qualitycheck','qc_rawmaterial',
            'qc_printing','qc_ecl','qc_slitting','qc_pouching','qc_certificate',
            'quotation_new','account_ledger'
        ];
        $segment = request()->segment(1);
        if (in_array($segment, $qc_routes)) {
            Config::set('snappy.pdf.binary', env('WKHTMLTOPDF', '/usr/local/bin/wkhtmltopdf'));
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess()
    {
        $this->response_json['data'] = (object)$this->data;
        $this->response_json['status'] = 1;
        return response()->json($this->response_json, 200);
    }
    public function responseSuccessWithoutObject()
    {
        $this->response_json['data'] = $this->data;
        $this->response_json['status'] = 1;
        return response()->json($this->response_json, 200);
    }
    public function responseSuccessPagination()
    {
        $this->response_json = $this->data;
        $this->response_json['status'] = 1;
        return response()->json($this->response_json, 200);
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccessWithoutDataObject()
    {
        $this->response_json['status'] = 1;
        return response()->json($this->response_json, 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError()
    {
        if (count($this->data)) {
            $this->response_json['data'] = $this->data;
        }
        $this->response_json['status'] = 0;
        return response()->json($this->response_json, 200);
    }

    public function responseSuccesswithMessage()
    {
        if (count($this->data)) {
            $this->response_json['data'] = $this->data;
        }
        if (!isset($this->response_json['status']))
            $this->response_json['status'] = 1;

        // Log::alert('response' , $this->data);
        return response()->json($this->response_json, 200);
    }
    public function currentuser()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            
            return $user;
        } else {
            return false;
        }
    }
    public function userCollection($user)
    {
        //'Bearer ' . 
        return collect([
            'id' => $user->id ?? '',
            'name' => $user->full_name ?? '',
            // 'employee_id' => $user->employee_id ?? '',
            'employee_id' => $user->emp_id ?? '',
            'email' => $user->email ?? '',
            'user_type' => $user->emp_type ?? '',
            'access_token' => $user->createToken('Nsure token for user login')->accessToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function responseSuccessWithoutObjectNew()
    {
        $this->response_json['data'] = $this->data;
        $this->response_json['status'] = 99;
        return response()->json($this->response_json, 200);
    }
}
