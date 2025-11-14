<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\CountryDatatable;
use App\Models\{
    Country,
    CountryRating,
};
use Illuminate\Http\Request;
use App\Http\Requests\CountriesRequest;
use Carbon\Carbon;
use Sentinel;

class CountryController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:country.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:country.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:country.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:country.delete', ['only' => ['destroy']]);
        $this->title = trans("country.country");
        view()->share('title', $this->title);
        $this->mid_level = CountryRating::where('slug','!=','country-weightage')->orderBy('name','asc')->pluck('name','id')->toArray();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(CountryDatatable $dataTable)
    {
        return $dataTable->render('countries.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['mid_level'] = $this->mid_level;
        return response()->json([
            'html' =>  view('countries.create', $this->data)->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CountriesRequest $request)
    {
        $check_entry = Country::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('countries.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = Country::create($input);
        return redirect()->route('country.index')->with('success' , __('country.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        return redirect()->route('country.edit', $id);
        // $country = Country::findOrFail($id);
        // return view('countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $country = Country::find($id);
        $this->data['country'] = $country;
        $this->data['mid_level'] = $this->mid_level;
        return response()->json(['html' => view('countries.edit',$this->data)->render()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, CountriesRequest $request)
    {
        $country = Country::findOrFail($id);
        $input = $request->all();
        $country->update($input);
        return redirect()->route('country.index')->with('success' , __('country.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        if ($country) {
            $dependency = $country->deleteValidate($id);
            if (!$dependency) {
                $country->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('country.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    // public function history($id)
    // {
    //     view()->share('module_action', ['page_title' => __('common.history'), 'back_action' => route('countries.index'), 'text' => __('common.back'),]);
    //     $Country = Country::find($id);
    //     $history = $Country->revisionHistory->sortByDesc('created_at');
    //     return view('comman.history', compact('history'));
    // }

    // public function ajaxAllCountries()
    // {

    //     $country = Country::pluck('country', 'id')->toArray();
    //     if (!empty($country)) {
    //         return $country;
    //     } else {
    //         return array();
    //     }
    // }
}
