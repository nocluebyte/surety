<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\ProjectDetail;
use App\Http\Requests\ProjectDetailRequest;
use App\DataTables\ProjectDetailDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Sentinel;
use Carbon\Carbon;

class ProjectDetailController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index', 'getProjectDetailCurrencySymbol']]);
        $this->middleware('permission:project-details.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:project-details.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:project-details.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:project-details.delete', ['only' => 'destroy']);
        $this->common = new CommonController();
        $this->title = trans('project_details.project_details');
        view()->share('title', $this->title);
    }

    public function index(ProjectDetailDataTable $datatable)
    {
        return $datatable->render('project_details.index');
    }

    public function create()
    {
        $this->data['beneficiaries'] = $this->common->getBeneficiary();
        $this->data['type_of_project'] = $this->common->getProjectType();
        $this->data['seriesNumber'] = codeGenerator('project_details', 7, 'PIN');
        return view('project_details.create', $this->data);
    }

    public function store(ProjectDetailRequest $request)
    {
        $check_entry = ProjectDetail::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->project_name == $request['project_name'])) {
            return redirect()->route('project-details.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        DB::beginTransaction();
        try {
            $input = [
                'code' => codeGenerator('project_details', 7, 'PIN'),
                'beneficiary_id' => $request['beneficiary_id'],
                'project_name' => $request['project_name'],
                'project_description' => $request['project_description'],
                'project_value' => $request['project_value'],
                'type_of_project' => $request['type_of_project'],
                'project_start_date' => $request['project_start_date'],
                'project_end_date' => $request['project_end_date'],
                'period_of_project' => $request['period_of_project'],
            ];

            $project_details = ProjectDetail::create($input);

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project-details.create')->with('error', __('common.something_went_wrong_please_try_again'));
        }

        if ($request->save_type == "save") {
            return redirect()->route('project-details.create')->with('success', __('project_details.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('project-details.index')->with('success', __('project_details.create_success'));
        } else {
            return redirect()->route('project-details.index')->with('success', __('project_details.create_success'));
        }
    }

    public function show($id)
    {
        $project_details = ProjectDetail::findOrFail($id);
        $this->common->markAsRead($project_details);
        $this->data['project_details'] = $project_details;
        $this->data['table_name'] = $project_details->getTable();
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($project_details->beneficiary->country_id);
        return view('project_details.show', $this->data);
    }

    public function edit($id)
    {
        $project_details = ProjectDetail::findOrFail($id);
        $this->data['beneficiaries'] = $this->common->getBeneficiary($project_details->beneficiary_id);
        $this->data['type_of_project'] = $this->common->getProjectType($project_details->type_of_project);
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($project_details->beneficiary->country_id);
        $this->data['project_details'] = $project_details;
        return view('project_details.edit', $this->data);
    }

    public function update($id, ProjectDetailRequest $request)
    {
        DB::beginTransaction();
        try{
            $project_details = ProjectDetail::findOrFail($id);
            $input = $request->validated();
            $project_details->update($input);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        if ($request->save_type == "save") {
            return redirect()->route('project-details.edit',[encryptId($project_details->id)])->with('success', __('project_details.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('project-details.index')->with('success', __('project_details.update_success'));
        } else {
            return redirect()->route('project-details.index')->with('success', __('project_details.update_success'));
        }
    }

    public function destroy($id)
    {
        $project_details = ProjectDetail::findOrFail($id);

        if($project_details)
        {
            $dependency = $project_details->deleteValidate($id);
            if(!$dependency)
            {
                $project_details->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('project_details.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function getProjectDetailCurrencySymbol(Request $request)
    {
        $beneficiary_id= $request->beneficiary_id;
        if($beneficiary_id){
            $currencySymbol = DB::table('beneficiaries')
            // ->select('currencys.symbol')
            ->where('beneficiaries.id', $beneficiary_id)
            ->leftJoin('countries', 'beneficiaries.country_id', '=', 'countries.id')
            ->leftJoin('currencys', 'countries.id', '=', 'currencys.country_id')
            ->pluck('currencys.symbol')
            ->first();
            return $currencySymbol;
        }
    }
}
