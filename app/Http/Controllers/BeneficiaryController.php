<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Beneficiary;
use App\Models\{Country, State, User, Role, DMS, ProposalBeneficiaryTradeSector, CasesActionPlan};
use App\Http\Controllers\Controller;
use App\Http\Requests\BeneficiaryRequest;
use App\DataTables\BeneficiaryDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Centaur\AuthManager;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Exceptions\MailTemplateException;
use App\Imports\BeneficiaryImport;
use App\Exports\BeneficiaryImportErrorExport;
use Maatwebsite\Excel\Facades\Excel;

class BeneficiaryController extends Controller
{
    public function __construct(AuthManager $authManager)
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['only' => ['create', 'store', 'show', 'update', 'destroy', 'edit']]);
        $this->middleware('permission:beneficiary.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:beneficiary.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:beneficiary.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:beneficiary.delete', ['only' => 'destroy']);
        $this->middleware('permission:cases.initiate_review', ['only' => 'initiateReview']);
        $this->middleware('permission:beneficiary.import', ['only' => ['import', 'BeneficiaryImportFiles']]);
        $this->common = new CommonController();
        $this->title = trans('beneficiary.beneficiary');
        view()->share('title', $this->title);

        $this->authManager = $authManager;
    }

    public function index(BeneficiaryDataTable $dataTable)
    {
        $this->data['beneficiary_type'] = Config('srtpl.filters.beneficiary_type_filter');
        $this->data['establishment_type_id'] = $this->common->getEstablishmentType();
        return $dataTable->render('beneficiary.index', $this->data);
    }

    public function create()
    {
        $this->data['countries'] = $this->common->getCountries();
        $this->data['states'] = [];
        if(old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }
        $this->data['ministry_type_id'] = $this->common->getMinistryType();
        $this->data['establishment_type'] = $this->common->getEstablishmentType();
        $this->data['trade_sector_id'] = $this->common->getTradeSector();
        $this->data['seriesNumber'] = codeGenerator('beneficiaries', 7, 'BIN');
        $this->data['isCountryIndia'] = true;

        return view('beneficiary.create', $this->data);
    }

    public function store(BeneficiaryRequest $request)
    {
        $check_entry = Beneficiary::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->email == $request['email'])) {
            return redirect()->route('beneficiary.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        DB::beginTransaction();
        try {
            $generateOtp = $this->common->generateRandumCodeEmail();

            $roleId = Role::where('slug', 'beneficiary')->value('id');
            if(!isset($roleId)){
                return redirect()->route('beneficiary.create')->with('error', 'Role Not Found, Please Check the Role List');
            }

            $loginUser = Sentinel::getUser();
            $user_id = $loginUser ? $loginUser->id : 0;

            $role_details = Role::findOrFail($roleId);
            $role_permissions = $role_details->permissions;

            $user_input = [
                'email' => $request['email'],
                'password' => Hash::make($generateOtp),
                'first_name' => $request['company_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'mobile' => $request['mobile'],
                'roles_id' => $roleId,
                'is_ip_base' => $request->get('is_ip_base', 'No'),
                'ip' => request()->ip(),
                'created_by' => $user_id,
                'is_active' => 'Yes',
                'permissions' => $role_permissions,
            ];

            $activate = (bool)$request->get('activate', true);

            $result = $this->authManager->register($user_input, $activate);

            $user_id = $result->user->id;

            $user = User::findOrFail($user_id);
            $user->update($user_input);

            $result->user->roles()->sync($roleId);
            $user_id = $user->id;

            $input = [
                'code' => codeGenerator('beneficiaries', 7, 'BIN'),
                // 'company_code' => $request['company_code'],
                // 'reference_code' => $request['reference_code'],
                'registration_no' => $request['registration_no'],
                'company_name' => $request['company_name'],
                'beneficiary_type' => $request['beneficiary_type'],
                'ministry_type_id' => $request['ministry_type_id'],
                'establishment_type_id' => $request['establishment_type_id'],
                'bond_wording' => $request['bond_wording'],
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'pan_no' => $request['pan_no'],
                'gst_no' => $request['gst_no'],
                'website' => $request['website'],
                'user_id' => $user_id,
                'pincode' => $request['pincode'],
            ];

            $beneficiary = Beneficiary::create($input);

            $beneficiary_id = $beneficiary->id;

            $tradeSector = $request->tradeSector;
            if (!empty($tradeSector) && count($tradeSector) > 0) {
                foreach ($tradeSector as $row) {
                    $tradeSectorArr = [
                        // 'beneficiary_id' => $beneficiary_id,                        
                        'trade_sector_id' => $row['trade_sector_id'] ?? NULL,
                        'from'=> $row['from'] ?? NULL,
                        'till'=> $row['till'] ?? NULL,                        
                        'is_main'=> $row['is_main'] ?? 'No',                        
                    ];
                    $beneficiary->proposalBeneficiaryTradeSector()->create($tradeSectorArr); 
                }
            }

            if($request['bond_attachment']){
                $this->common->storeMultipleFiles($request, $request['bond_attachment'], 'bond_attachment', $beneficiary, $beneficiary_id, 'beneficiary');
            }

            // $this->common->sendMail('login_details', $request['email'], $generateOtp, $request['company_name']);

            DB::commit();
        }
        catch (MailTemplateException $th) {
            DB::rollback();
            return redirect()->route('beneficiary.create')->with('error', $th->getMessage());
        }
        catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            return redirect()->route('beneficiary.create')->with('error', __('common.something_went_wrong_please_try_again'));
        }

        if ($request->save_type == "save") {
            return redirect()->route('beneficiary.create')->with('success', __('beneficiary.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('beneficiary.index')->with('success', __('beneficiary.create_success'));
        } else {
            return redirect()->route('beneficiary.index')->with('success', __('beneficiary.create_success'));
        }
    }

    public function show($id)
    {
        $beneficiary = Beneficiary::withCount('Pending','dMS' ,'country', 'state', 'user', 'establishmentTypeId', 'ministryType')->findOrFail($id);

        $this->common->markAsRead($beneficiary);

        $tradeSector = ProposalBeneficiaryTradeSector::
            leftJoin('trade_sectors','trade_sectors.id','=','proposal_beneficiary_trade_sectors.trade_sector_id')
            ->select(['trade_sectors.name', 'proposal_beneficiary_trade_sectors.from', 'proposal_beneficiary_trade_sectors.till', 'proposal_beneficiary_trade_sectors.is_main'])
            ->where('proposalbeneficiarytradesectorsable_id', $beneficiary->id)->where('proposalbeneficiarytradesectorsable_type', 'Beneficiary')->get();

        $this->data['tradeSector'] = $tradeSector;
        $case_pending_count = $beneficiary->pending_count;
        $underwriter = $this->common->getUnderWriterOpction();
        $table_name =  $beneficiary->getTable();
        $this->data['underwriter'] = $underwriter;
        $this->data['table_name'] = $table_name;
        $this->data['beneficiary'] = $beneficiary;
        $this->data['show_initiate_review'] = $case_pending_count == 0;
        $this->data['dms_data'] = $beneficiary->dMS;

        // Regular_Review Date 

        $case_action_plan = CasesActionPlan::with(['cases','casesLimitStrategy'])
            ->whereHas('cases', function ($qry) use ($id) {
                $qry->whereNotNull('casesable_id')->where('casesable_type' , 'Beneficiary')->where(['casesable_id' =>  $id]);
            })->orderBy('id', 'DESC')->first();

        if ($case_action_plan && $case_action_plan->casesLimitStrategySaveData) {
            $latestData = array_filter($case_action_plan->casesLimitStrategySaveData->toArray());
            $latestLogData = array_filter($case_action_plan->casesLimitStrategy->toArray());
            $this->data['casesLimitStrategylog'] = array_values($latestLogData);
            krsort($latestData);
            if ($latestData) {
                $this->data['casesLimitStrategy'] = $latestData;
            }
        }

        // Group Cap        
        $proposed_group_cap = $case_action_plan->casesLimitStrategySaveData->proposed_group_cap ?? 0;
        $proposed_individual_cap = $case_action_plan->casesLimitStrategySaveData->proposed_individual_cap ?? 0;
        $proposed_overall_cap = $case_action_plan->casesLimitStrategySaveData->proposed_overall_cap ?? 0;
        $this->data['total_group_cap'] = ($proposed_group_cap > 0) ? $proposed_group_cap : 0;
        $this->data['total_individual_cap'] = $proposed_individual_cap ?? 0;
        $this->data['total_overall_cap'] = $proposed_overall_cap ?? 0;

        return view('beneficiary.show',$this->data);
    }

    public function edit($id)
    {
        $beneficiary = Beneficiary::with('user','dMS', 'country')->findOrFail($id);

        $beneficiaryTradeSector = ProposalBeneficiaryTradeSector::with([])->where('proposalbeneficiarytradesectorsable_id',$beneficiary->id)->where('proposalbeneficiarytradesectorsable_type', 'Beneficiary')->get();
        $this->data['beneficiaryTradeSector'] = $beneficiaryTradeSector;
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] =  $this->common->getStates($beneficiary->country_id);
        $this->data['ministry_type_id'] = $this->common->getMinistryType($beneficiary->ministry_type_id);
        $this->data['establishment_type'] = $this->common->getEstablishmentType($beneficiary->establishment_type_id);
        $this->data['trade_sector_id'] = $this->common->getTradeSector($beneficiary->trade_sector_id);

        $this->data['dms_data'] = $beneficiary->dMS;

        $selected_country = $beneficiary->country->name;
        $this->data['isCountryIndia'] = isset($selected_country) && strtolower($selected_country) == 'india' ? true : false;

        $this->data['beneficiary'] = $beneficiary;
        return view('beneficiary.edit', $this->data);
    }

    public function update($id, BeneficiaryRequest $request)
    {
        DB::beginTransaction();
        try{
            $beneficiary = Beneficiary::with('dMS')->findOrFail($id);

            $beneficiary_id = $beneficiary->id;

            $input = [
                // 'company_code' => $request['company_code'],
                // 'reference_code' => $request['reference_code'],
                'registration_no' => $request['registration_no'],
                'company_name' => $request['company_name'],
                'beneficiary_type' => $request['beneficiary_type'],
                'ministry_type_id' => $request['ministry_type_id'],
                'establishment_type_id' => $request['establishment_type_id'],
                'bond_wording' => $request['bond_wording'],
                // 'email' => $request['email'],
                // 'phone_no' => $request['mobile'],
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'pan_no' => $request['pan_no'],
                'gst_no' => $request['gst_no'],
                'website' => $request['website'],
                'pincode' => $request['pincode'],
            ];

            $beneficiary->update($input);

            $tradeSector_id = collect($request->tradeSector)->pluck('beneficiary_trade_item_id')->toArray();
            $existing_tradeSector = $beneficiary->proposalBeneficiaryTradeSector()->pluck('id')->toArray();
            $diff_tradeSector = array_diff($existing_tradeSector, $tradeSector_id);

            $beneficiary->proposalBeneficiaryTradeSector()->whereIn('id', $diff_tradeSector)->get()->each(function ($btsItem) {
                $btsItem->delete();
            });

            $tradeSector = $request->tradeSector;
            if (!empty($tradeSector) && count($tradeSector) > 0) {
                foreach ($tradeSector as $row) {
                    $tradeSectorArr = $beneficiary->proposalBeneficiaryTradeSector()->updateOrCreate([
                        'id'=>$row['beneficiary_trade_item_id'] ?? null
                    ],[
                        'trade_sector_id' => $row['trade_sector_id'] ?? NULL,
                        'from'=> $row['from'] ?? NULL,
                        'till'=> $row['till'] ?? NULL,
                        'is_main'=> $row['is_main'] ?? 'No',
                    ]);
                }
            }

            // Update DMS documents

            if($request['bond_attachment']){
                $this->common->updateMultipleFiles($request, $request['bond_attachment'], 'bond_attachment', $beneficiary, $beneficiary_id, 'beneficiary');
            }


            // foreach (['bond_attachment'] as $documentType) {
            //     $existingDoc = $dmsModel->dMS()->where('attachment_type', $documentType)->first();

            //     $filePath = uploadFile($request, 'beneficiary/' . $beneficiary_id, $documentType);
            //     $fileName = basename($filePath);

            //     if($request->hasFile($documentType))
            //     {
            //         if(isset($existingDoc->attachment)) {
            //             File::delete($existingDoc->attachment);
            //             $existingDoc->update([
            //                 'file_name' => $fileName,
            //                 'attachment' => $filePath,
            //             ]);
            //         } else {
            //             $dmsModel->dMS()->create([
            //                 'file_name' => $fileName,
            //                 'attachment' => $filePath,
            //                 'attachment_type' => $documentType,
            //             ]);
            //         }
            //     }
            // }

            // $dmsModel->save();

            // Update User

            $user = User::findOrFail($beneficiary->user_id);

            $user_input = [
                'email' => $request['email'],
                'first_name' => $request['company_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'mobile' => $request['mobile'],
            ];

            $user->update($user_input);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        if ($request->save_type == "save") {
            return redirect()->route('beneficiary.edit',[encryptId($beneficiary_id)])->with('success', __('beneficiary.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('beneficiary.index')->with('success', __('beneficiary.update_success'));
        } else {
            return redirect()->route('beneficiary.index')->with('success', __('beneficiary.update_success'));
        }
    }

    public function destroy($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);

        $dms_data = DMS::where('dmsable_id', $id);

        if($beneficiary)
        {
            $dependency = $beneficiary->deleteValidate($id);
            if(!$dependency)
            {
                foreach($dms_data->pluck('attachment') as $dms_item)
                {
                    File::delete($dms_item);
                }

                $beneficiary->dMS()->delete();
                $beneficiary->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('beneficiary.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
    public function initiateReview(Request $request){

       $beneficiary =  Beneficiary::findOrFail($request->beneficiary_id);

       list($underwriter_type,$underwriter_id) = parseGroupedOptionValue($request->underwriter_id);

       $cases = $beneficiary->cases()->create([
            'case_type'=>'Review',
            'underwriter_id'=> $underwriter_id ?? null,
            'underwriter_type'=>$underwriter_type ?? null,
            'beneficiary_id' => $request->beneficiary_id,
            'underwriter_assigned_date'=> $request->underwriter_id ? $this->now : null,

       ]);

       if(isset($request->underwriter_id)){
            $beneficiary->underwriterCasesLog()->create([
                'cases_id' => $cases->id,
                'casesable_type'=>$cases->casesable_type ?? null,
                'casesable_id'=>$cases->casesable_id ?? null,
                'underwriter_id'=> $underwriter_id ?? null,
                'underwriter_type'=>$underwriter_type ?? null,
            ]);
        }

       return back()->with('success', __('beneficiary.review_generate'));
    }

    public function import()
    {
        return view('beneficiary.import.import');
    }

    public function BeneficiaryImportFiles(Request $request)
    {
        // dd($request->all());
        ini_set('max_execution_time', 900);
        ini_set('memory_limit',-1);
        DB::beginTransaction();
        try {
            $import = new BeneficiaryImport($this->authManager);
            $import->import($request->file('file'));
            $failures = $import->failures();
            $errors = [];
            foreach ($failures as $key => $value) {
                // dd($value);
                $index = $value->row();
                $attribute = $value->attribute();
                $values =$value->values();
                $error = $value->errors()[0];
                $errors[$index]['attribute'][] = $attribute;
                $errors[$index]['values'] = $values;
                $errors[$index]['error'][$attribute] = $error;
            }
            $this->data['excel_error'] = $errors;
            // dd($errors);
            session()->flash('excel_error',$errors);
            DB::commit();

            if (count($errors) == 0) {
                return redirect()->route('beneficiary_import')->withSuccess('file imported successfully');
            }
            else
            {
                return redirect()->route('beneficiary_import')->withErrors('in file has some invalid data please check and try again.');
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th->getMessage());
            return back()->withErrors('Something went wrong, please try again.');
        }
    }

    public function beneficiaryImportErrorExport(Request $request){
        try {
            $exportdata = json_decode($request->error,true);
            return Excel::download(new BeneficiaryImportErrorExport($exportdata),'error.xlsx');
        } catch (\Throwable $th) {
            return "Something went wrong, please try again.";
        }
    }
}
