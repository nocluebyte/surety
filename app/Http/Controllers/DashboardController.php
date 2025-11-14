<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use Illuminate\Http\Request;
use App\Models\{User,Account, BidBond, PerformanceBond, AdvancePaymentBond, RetentionBond, MaintenanceBond, BondPoliciesIssueChecklist, Principle, Beneficiary, BondPoliciesIssue, Setting, Nbi, Proposal,CasesDecision};
use DB;
use Sentinel;
use Carbon\Carbon;
use Str;
use App\Service\DashboardService;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        // $this->middleware('permission:department.list', ['only' => ['index', 'show']]);
        // $this->middleware('permission:department.add', ['only' => ['create', 'store']]);
        // $this->middleware('permission:department.edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:department.delete', ['only' => ['destroy']]);

        $this->common = new CommonController();
        $this->title = "Dashboard";
        view()->share('title', $this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DashboardService $dashboardService)
    {
       $route = $dashboardService->getDashboard();

       return redirect()->route($route);
    }

    public function masterPages()
    {
        $this->data['master_title'] = __('master.masters');
        return view('masters.index',$this->data);
    }

    /** Start revisions table logs module */
    public function logs()
    {
        return view('logs');
    }

    public function loadMoreLogs(Request $request)
    {
        if ($request->ajax()) {
            $fromDate = Carbon::now()->today()->subMonth(3);
            $toDate = Carbon::now()->today();

            if ($request->id > 0) {
                $logsData = DB::table('revisions')
                    ->leftJoin('users', 'revisions.user_id', '=', 'users.id')
                    ->select('revisions.id', 'revisions.revisionable_type', 'revisions.old_value', 'revisions.new_value', 'revisions.created_at')
                    ->selectRaw("REPLACE(revisions.key, '_', ' ') as field_name")
                    ->selectRaw("CONCAT(users.first_name, ' ', users.last_name) as user_name")
                    ->whereDate('revisions.created_at', '>=', $fromDate)
                    ->whereDate('revisions.created_at', '<=', $toDate)
                    ->where('revisions.id', '<', $request->id)
                    ->orderByDesc('revisions.id')
                    // ->groupBy('revisions.created_at')
                    ->limit(20)
                    ->get();
                // dd($logsData);
            } else {
                $logsData = DB::table('revisions')
                    ->leftJoin('users', 'revisions.user_id', '=', 'users.id')
                    ->select('revisions.id', 'revisions.revisionable_type', 'revisions.old_value', 'revisions.new_value', 'revisions.created_at')
                    ->selectRaw("REPLACE(revisions.key, '_', ' ') as field_name")
                    ->selectRaw("CONCAT(users.first_name, ' ', users.last_name) as user_name")
                    ->whereDate('revisions.created_at', '>=', $fromDate)
                    ->whereDate('revisions.created_at', '<=', $toDate)
                    ->orderByDesc('revisions.id')
                    ->when($request->key, function($sql) use($request) {
                        $sql->where('key', $request->key);
                    })
                    ->when($request->revisionable_id, function($sql) use($request) {
                        $sql->where('revisionable_id', $request->revisionable_id);
                    })
                    ->limit(20)
                    ->get();
                // dd($logsData);
            }

            $logArr = [];
            if (!empty($logsData)) {
                foreach ($logsData  as $key => $log) {
                    $logArr[$log->created_at][$key] = $log;
                }
            }
            // dd($logArr);
            // dd($logsData);
            // $datetime = !empty($logsData->created_at) ? date("h:i A", strtotime($logsData->created_at)) : "";
            // dd($logsData->groupBy($datetime));

            $output = '';
            $last_id = '';
            foreach ($logArr as $key => $logsDataArr) {
                // dd(str_replace('App\Models\\', ' ', current($logsDataArr)->revisionable_type));


                if (!$logsData->isEmpty()) {
                    $badgeColorArr = ['danger', 'success', 'primary', 'warning', 'info'];
                    $i = 0;
                    // dd($logsDataArr);
                    $datetime = !empty($key) ? date("d-m-Y | h:i A", strtotime($key)) : "";
                    $module = str_replace('App\Models\\', ' ', current($logsDataArr)->revisionable_type);

                    $output .= '
                    <div class="timeline-item">
                        <div class="timeline-badge">
                            <div class="bg-' . $badgeColorArr[$i] . '"></div>
                        </div>   
                        <div class="timeline-label">
                            <span class="text-primary font-weight-bold">' . $datetime . '</span>
                        </div> <div class="timeline-content">
                        <h3>' . $module . '</h3>';

                    foreach ($logsDataArr as $row) {
                        // dd($row);

                        $module = !empty($row->revisionable_type) ? str_replace('App\Models\\', ' ', $row->revisionable_type) : '';
                        $username = $row->user_name ?? '';
                        $fieldname = $row->field_name ?? '';
                        $oldValue = $row->old_value ?? '';
                        $newValue = $row->new_value ?? '';

                        $output .= '
                       
                            <br>
                            <p>' . $username . ' has updated <b>' . ucfirst($fieldname) . '</b></p>
                            <p><b>Old Value : </b>' . $oldValue . '</p>
                            <p><b>New Value : </b>' . $newValue . '</p>
                        ';

                        $last_id = $row->id;

                        if ($i >= 4) {
                            $i = 0;
                        } else {
                            $i++;
                        }
                    }
                    $output .= '</div></div>';
                    
                } else {
                    //     $output .= '
                    // <div id="load_more" style="width: 97%; margin-left: 35px;">
                    //     <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
                    // </div>';
                }
            }
            $output .= '
            <div id="load_more" style="width: 97%; margin-left: 35px;">
                <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="' . $last_id . '" id="load_more_button">Load More</button>
            </div>';
            return $output;
        }
    }
    /** End revisions table logs module */
}
