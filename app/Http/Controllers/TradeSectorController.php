<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{
    TradeSector,
    SectorRating,
};
use App\Http\Requests\TradeSectorRequest;
use App\DataTables\TradeSectorDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class TradeSectorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:trade_sector.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:trade_sector.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:trade_sector.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:trade_sector.delete', ['only' => 'destroy']);
        $this->title = trans('trade_sector.trade_sector');
        view()->share('title', $this->title);
        $this->mid_level = SectorRating::where('slug', '!=', 'sectors-weightage')->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    public function index(TradeSectorDataTable $datatable)
    {
        return $datatable->render('trade_sector.index');
    }

    public function create()
    {
        // $this->data['mid_level'] = Config('srtpl.trade_sector');
        $this->data['mid_level'] = $this->mid_level;
        return response()->json([
            'html' =>  view('trade_sector.create', $this->data)->render()
        ]);
    }

    public function store(TradeSectorRequest $request)
    {
        $check_entry = TradeSector::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->mid_level == $request['mid_level'])) {
            return redirect()->route('document_type.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = TradeSector::create($input);

        return redirect()->route('trade_sector.index')->with('success', __('trade_sector.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('trade_sector.edit', $id);
    }

    public function edit($id)
    {
        $trade_sector = TradeSector::find($id);
        $this->data['trade_sector'] = $trade_sector;
        // $this->data['mid_level'] = Config('srtpl.trade_sector');
        $this->data['mid_level'] = $this->mid_level;
        return response()->json(['html' => view('trade_sector.edit', $this->data)->render()]);
    }

    public function update($id, TradeSectorRequest $request)
    {
        $trade_sector = TradeSector::findOrFail($id);
        $input = $request->all();
        $trade_sector->update($input);
        return redirect()->route('trade_sector.index')->with('success', __('trade_sector.update_success'));
    }

    public function destroy($id)
    {
        $trade_sector = TradeSector::findOrFail($id);
        if($trade_sector)
        {
            $dependency = $trade_sector->deleteValidate($id);
            if(!$dependency)
            {
                $trade_sector->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('trade_sector.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
