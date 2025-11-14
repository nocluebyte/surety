<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\StatesDataTable;
use App\Models\{Country,State};

use Illuminate\Http\Request;
use App\Http\Requests\StatesRequest;
use Carbon\Carbon;
use Sentinel;

class StateController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:state.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:state.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:state.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:state.delete', ['only' => ['destroy']]);

        $this->common = new CommonController();
        $this->title = trans("state.state");
        view()->share('title', $this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StatesDataTable $dataTable)
    {
        return $dataTable->render('states.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['countries'] =  $this->common->getCountries();
        return response()->json(['html' =>  view('states.create', $this->data)->render()]);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatesRequest $request)
    {
        $check_entry = State::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->country_id == $request['country_id'])) {
            return redirect()->route('states.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->except('country_name');
        $model = State::create($input);

        return redirect()->route('state.index')->with('success' , __('state.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('state.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = State::find($id);
        $this->data['countries'] =  $this->common->getCountries($state->country_id);
        $this->data['state'] = $state;

        return response()->json(['html' => view('states.edit',$this->data)->render()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StatesRequest $request, $id)
    {
        $state = State::findOrFail($id);
        $input = $request->except('country_name');
        $state->update($input);

        return redirect()->route('state.index')->with('success' , __('state.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        if ($state) {
            $dependency = $state->deleteValidate($id);
            if (!$dependency) {
                $state->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('state.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
