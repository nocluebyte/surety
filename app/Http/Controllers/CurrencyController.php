<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\CurrencyDatatable;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Requests\CurrencyRequest;
use Carbon\Carbon;
use Sentinel;

class CurrencyController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:currency.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:currency.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:currency.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:currency.delete', ['only' => ['destroy']]);
        $this->title = trans("currency.title");
        view()->share('title', $this->title);
        $this->common = new CommonController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(CurrencyDatatable $dataTable)
    {
        return $dataTable->render('currency.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $countries = $this->countrieOption();

        $this->data['countries'] = $countries ?? ''; 

        return response()->json([
            'html' =>  view('currency.create', $this->data)->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CurrencyRequest $request)
    {
        $check_entry = Currency::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->name == $request['name'])) {
            return redirect()->route('currency.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        $input = $request->except(['_token']);
        $model = Currency::create($input);
        return redirect()->route('currency.index')->with('success' , __('common.create_success'));
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
        $currency = Currency::find($id);
        $this->data['currency'] = $currency;
        return response()->json(['html' => view('currency.edit',$this->data)->render()]);
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
        $currency = Currency::find($id);

        $countries = $this->countrieOption($currency->country_id);
       

        $this->data['countries'] = $countries ?? ''; 
        $this->data['currency'] = $currency ?? '';
        return response()->json(['html' => view('currency.edit',$this->data)->render()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, CurrencyRequest $request)
    {
        $currency = Currency::findOrFail($id);
        $input = $request->except(['_token','_method']);
        $currency->update($input);
        return redirect()->route('currency.index')->with('success' , __('common.update_success'));
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
        $currency = Currency::findOrFail($id);
        if ($currency) {
            $dependency = $currency->deleteValidate($id);
            if (!$dependency) {
                $currency->delete();
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

    public function countrieOption($currency_id = null)
    {
        $country_id = Currency::select(['country_id'])->pluck( 'country_id')->toArray();
        $currency_id = request()->get('currency_id', $currency_id);
        
        $countries = Country::where('is_active', 'Yes')
            ->whereNotIn('id', $country_id)
            ->when($currency_id, function ($query) use ($currency_id){
                $query->orWhere('id', $currency_id);
            })
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id')
            ->toArray();

        return $countries;
    }
}
