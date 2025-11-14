<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\AgencyRating;
use App\Http\Requests\AgencyRatingRequest;
use App\DataTables\AgencyRatingDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;

class AgencyRatingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:agency-rating.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:agency-rating.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:agency-rating.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:agency-rating.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('agency_rating.agency_rating');
        view()->share('title', $this->title);
    }

    public function index(AgencyRatingDataTable $datatable)
    {
        return $datatable->render('agency_rating.index');
    }

    public function create()
    {
        $rating_data = AgencyRating::pluck('agency_id')->toArray() ?? [];
        $this->data['agencies'] = $this->common->getAgency();

        return response()->json([
            'html' => view('agency_rating.create', $this->data)->render()
        ]);
    }

    public function store(AgencyRatingRequest $request)
    {
        $check_entry = AgencyRating::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->rating == $request['rating'])) {
            return redirect()->route('agency-rating.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->validated();
        $model = AgencyRating::create($input);

        return redirect()->route('agency-rating.index')->with('success', __('agency_rating.create_success'));
    }

    public function show($id)
    {
        return redirect()->route('agency-rating.edit', $id);
    }

    public function edit($id)
    {
        $agency_rating = AgencyRating::find($id);
        $agenciesArr = $agency_rating->pluck('agency_id')->toArray() ?? [];
        $this->data['agencies'] = $this->common->getAgency($agency_rating->agency_id) ?? [];

        $this->data['agency_rating'] = $agency_rating;
        return response()->json(['html' => view('agency_rating.edit', $this->data)->render()]);
    }

    public function update($id, AgencyRatingRequest $request)
    {
        $agency_rating = AgencyRating::findOrFail($id);
        $input = $request->validated();
        $agency_rating->update($input);
        return redirect()->route('agency-rating.index')->with('success', __('agency_rating.update_success'));
    }

    public function destroy($id)
    {
        $agency_rating = AgencyRating::findOrFail($id);
        if($agency_rating)
        {
            $dependency = $agency_rating->deleteValidate($id);
            if(!$dependency)
            {
                $agency_rating->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('agency_rating.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
