<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{AdverseInformation, DMS};
use App\Http\Requests\AdverseInformationRequest;
use App\DataTables\AdverseInformationDataTable;
use App\Http\Controllers\AdverseInformationController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Sentinel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdverseInformationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index', 'adverseInfoInactiveReason']]);
        $this->middleware('permission:adverse_information.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:adverse_information.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:adverse_information.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:adverse_information.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('adverse_information.adverse_information');
        view()->share('title', $this->title);
    }

    public function index(AdverseInformationDataTable $datatable)
    {
        $this->data['active_status'] = Config('srtpl.filters.active_status');
        $this->data['contractors'] = $this->common->getContractor();
        return $datatable->render('adverse_information.index', $this->data);
    }

    public function create()
    {
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['sources'] = Config('srtpl.sources') ?? [];
        $this->data['seriesNumber'] = codeGenerator('adverse_informations', 7, 'AIN');
        return view('adverse_information.create', $this->data);
    }

    public function store(AdverseInformationRequest $request)
    {
        $check_entry = AdverseInformation::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->source_of_adverse_information == $request['source_of_adverse_information'])) {
            return redirect()->route('adverse-information.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = [
            'code' => codeGenerator('adverse_informations', 7, 'AIN'),
            'contractor_id' => $request['contractor_id'],
            'source_of_adverse_information' => $request['source_of_adverse_information'],
            'adverse_information' => $request['adverse_information'],
            'source_date' => $request['source_date'],
        ];

        $model = AdverseInformation::create($input);

        $adverse_information_id = $model->id;

        $this->common->storeMultipleFiles($request, $request['adverse_information_attachment'], 'adverse_information_attachment', $model, $adverse_information_id, 'adverse_information');

        if ($request->save_type == "save") {
            return redirect()->route('adverse-information.create')->with('success', __('adverse_information.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('adverse-information.index')->with('success', __('adverse_information.create_success'));
        } else {
            return redirect()->route('adverse-information.index')->with('success', __('adverse_information.create_success'));
        }
    }

    public function show($id)
    {
        $adverse_information = AdverseInformation::with('dMS', 'inActiveReason')->findOrFail($id);
        $this->data['dms_data'] = $adverse_information->dMS;
        $table_name = $adverse_information->getTable();
        $this->data['table_name'] = $table_name;
        $this->data['adverse_information'] = $adverse_information;
        return view('adverse_information.show',$this->data);
    }

    public function edit($id)
    {
        $adverse_information = AdverseInformation::with('dMS')->find($id);
        $this->data['contractors'] = $this->common->getContractor($adverse_information->contractor_id) ?? [];

        $this->data['sources'] = Config('srtpl.sources') ?? [];
        $this->data['adverse_information'] = $adverse_information;
        return view('adverse_information.edit', $this->data);
    }

    public function update($id, AdverseInformationRequest $request)
    {
        $adverse_information = AdverseInformation::findOrFail($id);
        $input = [
            'contractor_id' => $request['contractor_id'],
            'source_of_adverse_information' => $request['source_of_adverse_information'],
            'adverse_information' => $request['adverse_information'],
            'source_date' => $request['source_date'],
        ];
        $adverse_information->update($input);

        if($request['adverse_information_attachment']){
            $this->common->updateMultipleFiles($request, $request['adverse_information_attachment'], 'adverse_information_attachment', $adverse_information, $adverse_information->id, 'adverse_information');
        }

        if ($request->save_type == "save") {
            return redirect()->route('adverse-information.edit',[encryptId($adverse_information->id)])->with('success', __('adverse_information.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('adverse-information.index')->with('success', __('adverse_information.update_success'));
        } else {
            return redirect()->route('adverse-information.index')->with('success', __('adverse_information.update_success'));
        }
    }

    public function destroy($id)
    {
        $adverse_information = AdverseInformation::findOrFail($id);

        $dms_data = DMS::where('dmsable_id', $id);

        foreach ($dms_data->pluck('attachment') as $dms) {
            File::delete($dms);
        }

        if($adverse_information)
        {
            $dependency = $adverse_information->deleteValidate($id);
            if(!$dependency)
            {
                $dms_data->delete();
                $adverse_information->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('adverse_information.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function adverseInfoInactiveReason(Request $request)
    {
        $adverseInformation = AdverseInformation::with('inActiveReason')->findOrFail($request->id);
        $adverseInformation->inActiveReason()->create([
            'reason' => $request->reason,
        ]);
    }
}
