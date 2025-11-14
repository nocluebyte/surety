<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{
    Group,
    Principle,
    GroupContractor,
};
use App\Http\Requests\GroupRequest;
use App\DataTables\GroupDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;
use DB;

class GroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index', 'getContractorGroup']]);
        $this->middleware('permission:group.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:group.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:group.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:group.delete', ['only' => 'destroy']);
        $this->common = new CommonController();
        $this->title = trans('group.group');
        view()->share('title', $this->title);
    }

    public function index(GroupDataTable $datatable)
    {
        return $datatable->render('group.index');
    }

    public function create()
    {
        $contractorIdArr = GroupContractor::pluck('contractor_id')->toArray();
        $group_data = Group::pluck('contractor_id')->toArray();
        $existing_data = array_merge($contractorIdArr, $group_data);
        $this->data['contractorIdArr'] = [];
        $this->data['contractors'] = collect($this->common->getContractor())->except($existing_data)->toArray();

        return view('group.create', $this->data);
    }

    public function store(GroupRequest $request)
    {
        $input = $request->all();
        $group_input = [
            'contractor_id' => $request['contractor_id'],
        ];
        $model = Group::create($group_input);
        $group_id = $model->id;
        if(count($input['contractorids']) > 0){
            foreach ($input['contractorids'] as $key => $row) {
                $groupArray =
                    [
                        'group_id' => $group_id,
                        'contractor_id' => (int)$key,
                        'type' => $row['type'],
                        'from_date' => $row['from_date'],
                        'till_date' => $row['till_date'],

                    ];
                GroupContractor::create($groupArray);
            }
        }
        if ($request->has('saveBtn')) {
            return redirect()->route('group.index',[$model->id])->with('success', __('common.create_success'));
        } else if ($request->has('saveExitBtn')) {
            return redirect()->route('group.index')->with('success', __('common.create_success'));
        } else {
            return redirect()->route('group.index')->with('success', __('common.create_success'));
        }
    }

    public function show($id)
    {
            $group = Group::with(['contractor:id,code,company_name','casesLimitStrategy'])->find($id);

            $this->data['group'] = $group;

            //group approved limit tab
           $pendingApplicationSubQuery = DB::table('cases')
           ->select('contractor_id', DB::raw('SUM(bond_value) as pending_application_limit'))
           ->where('status', 'Pending')
           ->groupBy('contractor_id');
   
           $approvedLimitSubQuery = DB::table('cases')
           ->join('cases_decisions', 'cases.id', '=', 'cases_decisions.cases_id')
           ->select('cases.contractor_id', DB::raw('SUM(cases_decisions.bond_value) as total_approved_limit'))
           ->where('cases.status', 'Completed')
           ->where('cases.is_amendment', 0)
           ->groupBy('cases.contractor_id');


           $group = Group::select([
               'principles.code', 
               'principles.company_name',
               DB::raw("NULL as type"),
               'countries.name as country',
               // DB::raw("SUM(pending_application.bond_value) as pending_application_limit"),
               // DB::raw("SUM(cases_decisions.bond_value) as total_approved_limit"),
               DB::raw('COALESCE(pending_apps.pending_application_limit, 0) as pending_application_limit'),
               DB::raw('COALESCE(approved_limits.total_approved_limit, 0) as total_approved_limit'),
               'cases_limit_strategys.proposed_individual_cap',
               'cases_limit_strategys.proposed_overall_cap',
               'cases_limit_strategys.proposed_valid_till as reguler_review_date',
               DB::raw("NULL as from_date"),
               DB::raw("NULL as till_date"),
               DB::raw('CONCAT(users.first_name," ",users.last_name) as created_by')
           ])
           ->leftJoin('principles',function($join){
               $join->on('groups.contractor_id','=','principles.id');
           })
           
           ->leftJoin('group_contractors',function($join)use($id){
                $join->on('group_contractors.group_id','=','groups.id')
                ->where('group_contractors.contractor_id',$id);
            })
           ->leftJoin('countries',function($join){
               $join->on('principles.country_id','=','countries.id');
           })
           ->leftJoin('cases_limit_strategys',function($join){
               $join->on('principles.id','=','cases_limit_strategys.contractor_id')
               ->where('is_current','0');
           })
           ->leftJoin('users',function($join){
               $join->on('groups.created_by','=','users.id');
           })
           ->leftJoinSub($pendingApplicationSubQuery, 'pending_apps', function ($join) {
               $join->on('principles.id', '=', 'pending_apps.contractor_id');
           })
           ->leftJoinSub($approvedLimitSubQuery, 'approved_limits', function ($join) {
               $join->on('principles.id', '=', 'approved_limits.contractor_id');
           })
           ->where('groups.id',$id)
           ->groupBy([
               'principles.id'
           ]);
   
           $groupMember = GroupContractor::select([
               'principles.code', 
               'principles.company_name',
               DB::raw("group_contractors.type"),
               'countries.name as country',
               // DB::raw("SUM(pending_application.bond_value) as pending_application_limit"),
               // DB::raw("SUM(cases_decisions.bond_value) as total_approved_limit"),
               DB::raw('COALESCE(pending_apps.pending_application_limit, 0) as pending_application_limit'),
               DB::raw('COALESCE(approved_limits.total_approved_limit, 0) as total_approved_limit'),
               'cases_limit_strategys.proposed_individual_cap',
               'cases_limit_strategys.proposed_overall_cap',
               'cases_limit_strategys.proposed_valid_till as reguler_review_date',
               DB::raw("group_contractors.from_date"),
               DB::raw("group_contractors.till_date"),
               DB::raw('CONCAT(users.first_name," ",users.last_name) as created_by')
           ])
           ->leftJoin('principles',function($join){
               $join->on('group_contractors.contractor_id','=','principles.id');
           })
           ->leftJoin('groups',function($join) use($id){
               $join->on('group_contractors.group_id','=','groups.id')
               ->where('groups.contractor_id',$id);
           })
           ->leftJoin('countries',function($join){
               $join->on('principles.country_id','=','countries.id');
           })
           ->leftJoin('cases_limit_strategys',function($join){
               $join->on('principles.id','=','cases_limit_strategys.contractor_id')
               ->where('is_current','0');
           })
            ->leftJoin('users',function($join){
               $join->on('groups.created_by','=','users.id');
           })
           ->leftJoinSub($pendingApplicationSubQuery, 'pending_apps', function ($join) {
               $join->on('principles.id', '=', 'pending_apps.contractor_id');
           })
           ->leftJoinSub($approvedLimitSubQuery, 'approved_limits', function ($join) {
               $join->on('principles.id', '=', 'approved_limits.contractor_id');
           })
           ->where('group_contractors.group_id',$id)
           ->groupBy([
               'principles.id'
           ]);

           $group_approved_limit = $group->unionAll($groupMember)
           ->get();

           $this->data['group_approved_limit'] = $group_approved_limit;

        return view('group.show', $this->data);
    }

    public function edit($id)
    {
        $group = Group::with('groupContractor', 'updatedBy')->findOrFail($id);

        $this->data['groupcontractor'] = GroupContractor::where('group_id', $id)->get();

        $groupIdArrData = Group::pluck('contractor_id')->toArray();
        $contractorIdArr = GroupContractor::pluck('contractor_id')->toArray();
        $groupUnique = array_unique($contractorIdArr);
        $groupId = array_merge($groupUnique, $groupIdArrData);

        $this->data['contractors'] = Principle::select('principles.company_name', 'principles.id')->where('is_active', 'Yes')
            ->whereNotIn('id', $groupId)
            ->orWhere('id', $group->contractor_id)
            // ->when($contractorIdArr, function ($qry) use ($contractorIdArr) {
            //     $qry->orWhereIn('id', $contractorIdArr);
            // })
            ->with('updatedBy')
            ->pluck('principles.company_name', 'id')->toArray();
        // dd($this->data['contractors']);
        $this->data['group'] = $group;
        $this->data['contractorIdArr'] = $contractorIdArr;
        $this->data['type'] = Config('srtpl.group_type');

        return view('group.edit', $this->data);
    }

    public function update($id, GroupRequest $request)
    {
        $user = Sentinel::getUser();
        $contractor_ids = array_keys($request->contractorids);
        $existing_group_contractor = GroupContractor::where('group_id', $id)->pluck('contractor_id')->toArray();

        $delete_group_contractor = array_diff($existing_group_contractor, $contractor_ids);
        $group = Group::findOrFail($id);

        $input = $request->all();

        $input_group_contractor = $request->except(['contractor', 'contractorids', 'saveBtn']);
        $group->update($input_group_contractor);

        $group_id  = $group->id;

        if (count($input['contractorids']) > 0) {
            GroupContractor::where('contractor_id', $delete_group_contractor)->delete();
            foreach ($input['contractorids'] as $key => $row) {
                $groupArr =
                    [
                        'group_id' => $group_id,
                        'contractor_id' => (int)$key,
                        'type' => $row['type'],
                        'from_date' => $row['from_date'],
                        'till_date' => $row['till_date']
                    ];
                    GroupContractor::updateOrCreate(['group_id' => $group_id, 'contractor_id' => (int)$key],$groupArr);
            }
        }

        if ($request->has('saveBtn')) {
            return redirect()->route('group.edit', encryptId($id))->with('success', __('common.update_success'));
        } else if ($request->has('saveExitBtn')) {
            return redirect()->route('group.index')->with('success', __('common.update_success'));
        } else {
            return redirect()->route('group.index')->with('success', __('common.update_success'));
        }
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        if ($group) {
            $dependency = $group->deleteValidate($id);
            if (!$dependency) {
                GroupContractor::where('group_id',$id)->delete();
                $group->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('users.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function getContractorGroup(Request $request)
    {
        $id = $request->id ?? '';

        $this->data['contractor'] = Principle::with(['country', 'updatedBy'])->where('is_active', 'Yes')->where('id',$id)->get();
        $this->data['type'] = Config('srtpl.group_type');
        // dd($this->data['contractor']);
        return response()->json(['html'=>view('group.group_row',$this->data)->render()]);
        // return $this->data['contractor'];

    }
}
