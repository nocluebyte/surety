<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Type,Setting};
use App\Http\Requests\TypeRequest;
use App\DataTables\TypesDataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RmTypesExport;
use Sentinel;
use Carbon\Carbon;
use DB;

class TypeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:RM_type.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:RM_type.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:RM_type.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:RM_type.delete', ['only' => ['destroy']]);
        $this->title = trans("RM_type.RM_type");
        view()->share('title', $this->title);
        // $this->middleware('sentinel.auth');
        /*
        $this->middleware('checkpermission.access:countries.create', ['only' => ['create', 'store']]);
        $this->middleware('checkpermission.access:countries.list', ['only' => ['index', 'show']]);
        $this->middleware('checkpermission.access:countries.edit', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission.access:countries.delete', ['only' => ['destroy']]);
        */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TypesDataTable $dataTable)
    {
        return $dataTable->render('masters.types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'html' =>  view('masters.types.create')->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeRequest $request)
    {
        $validated = $request->validated();
        $user = Sentinel::getUser();
        $validated['created_by'] = $user->id ?? '';
        $validated['ip'] = $request->ip();
        $validated['name'] = trim($request->name);
        $validated['display_in_rm_name'] = $request->display_in_rm_name;
        $attribute = Type::create($validated);
        try {
            $db_conn = DB::connection('mysql2');            
            $validated['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $db_conn->table('types')->insertGetId($validated);           
        } catch (\Exception $e) {}

        return redirect()->route('types.index')->with('success', __('common.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = Type::withCount('rmType')->find($id);
        return response()->json(['html' =>  view('masters.types.edit', compact('type'))->render()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeRequest $request, $id)
    {
        $type = Type::findOrFail($id);
        $validated = $request->validated();
        $user = Sentinel::getUser();
        $validated['updated_by'] = $user->id ?? '';
        $validated['update_from_ip'] = $request->ip();
        $validated['name'] = trim($request->name);
        $validated['display_in_rm_name'] = $request->display_in_rm_name;
        $type->update($validated);

        return redirect()->route('types.index')->with('success', __('common.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        if ($type) {
            $dependency = $type->deleteValidate($id);
            if (!$dependency) {
                $type->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('Type is used in:'.$dependency),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function checkUniqueName(Request $request, $id = '')
    {
        $name = trim($request->name);
        if($name != ''){
            $checkName = Type::where(['name' => $name])
                ->whereNull('deleted_at')
                ->when($id, function($q) use($id){
                    $q->where('id','!=',$id);
                })
                ->count();
            
            return ($checkName > 0) ? 'false' : 'true';
        }        
    }

    public function rmTypesExport(Request $request)
    {
        $settingsData = Setting::get();
        $settingsCmpNmData = $settingsData->where('group', 'company')->where('name', 'company_name')->first();
        $settingsCmpAddrData = $settingsData->where('group', 'company')->where('name', 'company_address')->first();
        $settingsCmpEmailData = $settingsData->where('group', 'company')->where('name', 'company_email')->first();

        $this->data['company_title'] = $settingsCmpNmData->value ?? '';
        $this->data['company_address'] = $settingsCmpAddrData->value ?? '';
        $this->data['company_email'] = $settingsCmpEmailData->value ?? '';

        return Excel::download(new RmTypesExport($this->data), 'RmTypes.xlsx');
    }
}
