<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\SmtpConfigurationDatatable;
use App\Models\SmtpConfiguration;
use Illuminate\Http\Request;
use App\Http\Requests\SmtpConfigurationRequest;
use Carbon\Carbon;
use Sentinel;
use Session;
use Flash;
use Mail;
use Centaur\Mail\CentaurWelcomeEmail;


class SmtpConfigurationController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:smtp_configuration.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:smtp_configuration.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:smtp_configuration.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:smtp_configuration.delete', ['only' => ['destroy']]);
        $this->title = trans("smtp_configuration.smtp_configuration");
        view()->share('title', $this->title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(SmtpConfigurationDatatable $dataTable)
    {
        return $dataTable->render('smtp-configuration.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->json([
            'html' =>  view('smtp-configuration.create')->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(SmtpConfigurationRequest $request)
    {
        $check_entry = SmtpConfiguration::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->from_name == $request['from_name'])) {
            return redirect()->route('smtp-configuration.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = $request->all();
        $model = SmtpConfiguration::create($input);
        return redirect()->route('smtp-configuration.index')->with('success' , __('smtp_configuration.create_success'));
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
        $this->data['smtp_configuration'] = SmtpConfiguration::find($id);
        return response()->json(['html' => view('smtp-configuration.view',$this->data)->render()]);
        // return redirect()->route('smtp_configuration.edit', $id);
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
        $this->data['smtp_configuration'] = SmtpConfiguration::find($id);
        return response()->json(['html' => view('smtp-configuration.edit',$this->data)->render()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, SmtpConfigurationRequest $request)
    {
        $smtp_configuration = SmtpConfiguration::findOrFail($id);
        $input = $request->all();
        $smtp_configuration->update($input);
        return redirect()->route('smtp-configuration.index')->with('success' , __('smtp_configuration.update_success'));

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
        $smtp_configuration = SmtpConfiguration::findOrFail($id);
        if ($smtp_configuration) {
            $smtp_configuration->delete();
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
