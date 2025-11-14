<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{
    ClaimExaminer,
    Role,
    User,
};
use App\Http\Requests\ClaimExaminerRequest;
use App\DataTables\ClaimExaminerDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Centaur\AuthManager;
use Sentinel;
use Carbon\Carbon;
use App\Exceptions\MailTemplateException;
use Illuminate\Support\Str;

class ClaimExaminerController extends Controller
{
    public function __construct(AuthManager $authManager)
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:claim_examiner.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:claim_examiner.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:claim_examiner.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:claim_examiner.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('claim_examiner.claim_examiner');
        view()->share('title', $this->title);

        $this->authManager = $authManager;
    }

    public function index(ClaimExaminerDataTable $datatable)
    {
        return $datatable->render('claim_examiner.index');
    }

    public function create()
    {
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] = [];
        if (old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }

        return view('claim_examiner.create', $this->data);
    }

    public function store(ClaimExaminerRequest $request)
    {
        $check_entry = ClaimExaminer::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->email == $request['email'])) {
            return redirect()->route('claim-examiner.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try {
            $generateOtp = $this->common->generateRandumCodeEmail();

            $roleId = Role::where('slug', 'claim-examiner')->value('id');
            if(!isset($roleId)){
                return redirect()->route('claim-examiner.create')->with('error', 'Role Not Found, Please Check the Role List');
            }

            $loginUser = Sentinel::getUser();
            $user_id = $loginUser ? $loginUser->id : 0;

            $role_details = Role::findOrFail($roleId);
            $role_permissions = $role_details->permissions;

            $user_input = [
                'email' => $request['email'],
                'password' => Hash::make($generateOtp),
                'first_name' => $request['first_name'],
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
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'post_code' => $request['post_code'],
                'user_id' => $user_id,
                'max_approved_limit' => $request['max_approved_limit'],
            ];

            $model = ClaimExaminer::create($input);

            // $this->common->sendMail('login_details', $request['email'], $generateOtp, $request['first_name']);

            DB::commit();
        }
        catch (MailTemplateException $th) {
            DB::rollback();
            return redirect()->route('claim-examiner.create')->with('error', $th->getMessage());
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('claim-examiner.create')->with('error', __('common.something_went_wrong_please_try_again'));
        }

        if ($request->save_type == "save") {
            return redirect()->route('claim-examiner.create')->with('success', __('claim_examiner.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('claim-examiner.index')->with('success', __('claim_examiner.create_success'));
        } else {
            return redirect()->route('claim-examiner.index')->with('success', __('claim_examiner.create_success'));
        }
    }

    public function show($id)
    {
        $claim_examiner = ClaimExaminer::findOrFail($id);
        $table_name =  $claim_examiner->getTable();
        $this->data['table_name'] = $table_name;
        $this->data['claim_examiner'] = $claim_examiner;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($claim_examiner->country_id);
        return view('claim_examiner.show',$this->data);
    }

    public function edit($id)
    {
        $claim_examiner = ClaimExaminer::with('user', 'country')->findOrFail($id);
        $this->data['countries'] = $this->common->getCountries();
        $this->data['states'] =  $this->common->getStates($claim_examiner->country_id);

        $this->data['claim_examiner'] = $claim_examiner;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($claim_examiner->country_id);
        return view('claim_examiner.edit', $this->data);
    }

    public function update($id, ClaimExaminerRequest $request)
    {
        DB::beginTransaction();
        try {
            $claim_examiner = ClaimExaminer::findOrFail($id);

            $claim_examiner_id = $claim_examiner->id;

            $input = [
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'max_approved_limit' => $request['max_approved_limit'],
            ];

            $claim_examiner->update($input);

            $user = User::findOrFail($claim_examiner->user_id);

            $user_input = [
                'email' => $request['email'],
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'mobile' => $request['mobile'],
            ];

            $user->update($user_input);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('claim-examiner.index')->with('error', __('common.something_went_wrong_please_try_again'));
            
        }

        if ($request->save_type == "save") {
            return redirect()->route('claim-examiner.edit',[encryptId($claim_examiner_id)])->with('success', __('claim_examiner.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('claim-examiner.index')->with('success', __('claim_examiner.update_success'));
        } else {
            return redirect()->route('claim-examiner.index')->with('success', __('claim_examiner.update_success'));
        }
    }

    public function destroy($id)
    {
        $claim_examiner = ClaimExaminer::findOrFail($id);
        if($claim_examiner)
        {
            $dependency = $claim_examiner->deleteValidate($id);
            if(!$dependency)
            {
                $claim_examiner->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('claim_examiner.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
