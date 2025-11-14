<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\InsuranceCompanies;
use App\Models\{Country,State};
use App\Http\Requests\InsuranceCompaniesRequest;
use App\DataTables\InsuranceCompaniesDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Sentinel;
use Session;

class InsuranceCompaniesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index', 'checkUniqueField']]);
        $this->middleware('permission:insurance_companies.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:insurance_companies.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:insurance_companies.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:insurance_companies.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('insurance_companies.insurance_companies');
        view()->share('title', $this->title);
    }

    public function index(InsuranceCompaniesDataTable $datatable)
    {
        return $datatable->render('insurance_companies.index');
    }

    public function create()
    {
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] =  [];
        if (old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }
        return view('insurance_companies.create', $this->data);
    }

    public function store(InsuranceCompaniesRequest $request)
    {
        $check_entry = InsuranceCompanies::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->email == $request['email'])) {
            return redirect()->route('insurance_companies.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        $input = [
            'company_name' => $request['company_name'],
            'email' => $request['email'],
            'phone_no' => $request['phone_no'],
            'address' => $request['address'],
            'city' => $request['city'],
            'post_code' => $request['post_code'],
            'country_id' => $request['country_id'],
            'state_id' => $request['state_id'],
        ];

        $model = InsuranceCompanies::create($input);

        if ($request->save_type == "save") {
            return redirect()->route('insurance_companies.create')->with('success', __('insurance_companies.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('insurance_companies.index')->with('success', __('insurance_companies.create_success'));
        } else {
            return redirect()->route('insurance_companies.index')->with('success', __('insurance_companies.create_success'));
        }
    }

    public function show($id)
    {
        return redirect()->route('insurance_companies.edit', $id);
    }

    public function edit($id)
    {
        $insurance_companies = InsuranceCompanies::find($id);
        $this->data['countries'] =  $this->common->getCountries($insurance_companies->country_id);
        $this->data['states'] =  $this->common->getStates($insurance_companies->country_id);
        $this->data['insurance_companies'] = $insurance_companies;
        return view('insurance_companies.edit', $this->data);
    }

    public function update($id, InsuranceCompaniesRequest $request)
    {
        $insurance_companies = InsuranceCompanies::findOrFail($id);
        $insurance_companies_id = $insurance_companies->id;
        $input = [
            'company_name' => $request['company_name'],
            'email' => $request['email'],
            'phone_no' => $request['phone_no'],
            'address' => $request['address'],
            'city' => $request['city'],
            'post_code' => $request['post_code'],
            'country_id' => $request['country_id'],
            'state_id' => $request['state_id'],
        ];

        $insurance_companies->update($input);

        if ($request->save_type == "save") {
            return redirect()->route('insurance_companies.edit',[encryptId($insurance_companies_id)])->with('success', __('insurance_companies.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('insurance_companies.index')->with('success', __('insurance_companies.update_success'));
        } else {
            return redirect()->route('insurance_companies.index')->with('success', __('insurance_companies.update_success'));
        }
    }

    public function destroy($id)
    {
        $insurance_companies = InsuranceCompanies::findOrFail($id);
        if($insurance_companies)
        {
            $dependency = $insurance_companies->deleteValidate($id);
            if(!$dependency)
            {
                $insurance_companies->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('insurance_companies.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
