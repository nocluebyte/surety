<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{Blacklist, Principle, DMS};
use App\Http\Requests\BlacklistRequest;
use App\DataTables\BlacklistDataTable;
use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Sentinel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BlacklistController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index', 'blacklistInactiveReason']]);
        $this->middleware('permission:blacklist.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:blacklist.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:blacklist.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:blacklist.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('blacklist.blacklist');
        view()->share('title', $this->title);
    }

    public function index(BlacklistDataTable $datatable)
    {
        $this->data['active_status'] = Config('srtpl.filters.active_status');
        return $datatable->render('blacklist.index', $this->data);
    }

    public function create()
    {
        // $blacklist_data = Blacklist::pluck('contractor_id')->toArray();
        // $this->data['contractors'] = collect($this->common->getContractor())->except($blacklist_data)->toArray() ?? [];
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['contractorOptions'] = [];
        $this->data['seriesNumber'] = codeGenerator('blacklists', 7, 'BLN');

        $this->data['sources'] = Config('srtpl.sources') ?? [];
        // $this->data['contractors'] = array_diff($this->common->getContractor(), $blacklist_data);

        return view('blacklist.create', $this->data);
    }

    public function store(BlacklistRequest $request)
    {
        $check_entry = Blacklist::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->contractor_id == $request['contractor_id'])) {
            return redirect()->route('blacklist.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = [
            'code' => codeGenerator('blacklists', 7, 'BLN'),
            'contractor_id' => $request['contractor_id'],
            'reason' => $request['reason'],
            'source' => $request['source'],
            'blacklist_date' => $request['blacklist_date'],
        ];

        $model = Blacklist::create($input);

        $blacklist_id = $model->id;

        $this->common->storeMultipleFiles($request, $request['blacklist_attachment'], 'blacklist_attachment', $model, $blacklist_id, 'blacklist');

        // $contractor = Principle::with('user')->where('id', $request['contractor_id'])->first();
        // $contractorStatus = $contractor->update(['status' => 'Blacklisted', 'is_active' => 'No']);
        // $contractor->user->update(['is_active' => 'No']);

        if ($request->save_type == "save") {
            return redirect()->route('blacklist.create')->with('success', __('blacklist.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('blacklist.index')->with('success', __('blacklist.create_success'));
        } else {
            return redirect()->route('blacklist.index')->with('success', __('blacklist.create_success'));
        }
    }

    public function show($id)
    {
        $blacklist = Blacklist::with('dMS', 'inActiveReason')->findOrFail($id);
        $this->data['dms_data'] = $blacklist->dMS;
        $table_name =  $blacklist->getTable();
        $this->data['table_name'] = $table_name;
        $this->data['blacklist'] = $blacklist;
        return view('blacklist.show',$this->data);
    }

    public function edit($id)
    {
        $blacklist = Blacklist::with('dMS')->find($id);

        $contractorArr = $blacklist->pluck('contractor_id')->toArray() ?? [];
        $this->data['contractors'] = $this->common->getContractor($blacklist->contractor_id) ?? [];

        $contractorOptions = [];
        if (!empty($this->data['contractors'])) {
            foreach ($this->data['contractors'] as $key => $value) {
                if(in_array($key,$contractorArr)){
                    $contractorOptions[$key] = ['disabled' => 'disabled'];
                    if($key == $blacklist->contractor_id){
                        $contractorOptions[$key] = ['' => ''];
                    }
                }
            }
        }
        $this->data['sources'] = Config('srtpl.sources') ?? [];
        $this->data['contractorOptions'] = $contractorOptions;

        $this->data['blacklist'] = $blacklist;
        return view('blacklist.edit', $this->data);
    }

    public function update($id, BlacklistRequest $request)
    {
        $blacklist = Blacklist::with('contractor')->findOrFail($id);
        $input = [
            'contractor_id' => $request['contractor_id'],
            'reason' => $request['reason'],
            'source' => $request['source'],
            'blacklist_date' => $request['blacklist_date'],
        ];

        $blacklist->update($input);

        if($request['blacklist_attachment']){
            $this->common->updateMultipleFiles($request, $request['blacklist_attachment'], 'blacklist_attachment', $blacklist, $blacklist->id, 'blacklist');
        }

        if ($request->save_type == "save") {
            return redirect()->route('blacklist.edit',[encryptId($blacklist->id)])->with('success', __('blacklist.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('blacklist.index')->with('success', __('blacklist.update_success'));
        } else {
            return redirect()->route('blacklist.index')->with('success', __('blacklist.update_success'));
        }
    }

    public function destroy($id)
    {
        $blacklist = Blacklist::findOrFail($id);

        $dms_data = DMS::where('dmsable_id', $id);

        foreach ($dms_data->pluck('attachment') as $dms) {
            File::delete($dms);
        }

        if($blacklist)
        {
            $dependency = $blacklist->deleteValidate($id);
            if(!$dependency)
            {
                $contractor = Principle::with('user')->where('id', $blacklist->contractor_id)->first();
                $contractorStatus = $contractor->update(['status' => 'Approved', 'is_active' => 'Yes']);
                $contractor->user->update(['is_active' => 'Yes']);

                $dms_data->delete();
                $blacklist->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('blacklist.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function blacklistInactiveReason(Request $request)
    {
        $blackList = Blacklist::with('inActiveReason')->findOrFail($request->id);
        $blackList->inActiveReason()->create([
            'reason' => $request->reason,
        ]);
    }
}
