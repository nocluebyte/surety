<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Broker;
use App\Models\{Country,State, User, Role, RoleUser};
use App\Http\Requests\BrokerRequest;
use App\DataTables\BrokerDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Centaur\AuthManager;
use Sentinel;
use Carbon\Carbon;
use App\Exceptions\MailTemplateException;

class BrokerController extends Controller
{
    protected $authManager;

    public function __construct(AuthManager $authManager)
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:broker.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:broker.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:broker.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:broker.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('broker.broker');
        view()->share('title', $this->title);

        $this->authManager = $authManager;
    }

    public function index(BrokerDataTable $datatable)
    {
        return $datatable->render('broker.index');
    }

    public function create()
    {
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] = [];
        if (old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }
        $this->data['isCountryIndia'] = true;

        return view('broker.create', $this->data);
    }

    public function store(BrokerRequest $request)
    {
        $check_entry = Broker::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->email == $request['email'])) {
            return redirect()->route('broker.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try {
            $generateOtp = $this->common->generateRandumCodeEmail();

            $roleId = Role::where('slug', 'broker')->value('id');
            if(!isset($roleId)){
                return redirect()->route('broker.create')->with('error', 'Role Not Found, Please Check the Role List');
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
                'company_name' => $request['company_name'],
                // 'first_name' => $request['first_name'],
                // 'middle_name' => $request['middle_name'],
                // 'last_name' => $request['last_name'],
                // 'email' => $request['email'],
                // 'phone_no' => $request['mobile'],
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'pan_no' => $request['pan_no'],
                'user_id' => $user_id,
            ];

            $model = Broker::create($input);

            foreach ($request->intermediaryDetails as $value) {
                
                $model->intermediaryDetails()->create($value);
            }
            // $this->common->sendMail('login_details', $request['email'], $generateOtp, $request['first_name']);

            DB::commit();
        }
        catch (MailTemplateException $th) {
            DB::rollback();
            return redirect()->route('broker.create')->with('error', $th->getMessage());
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('broker.create')->with('error', __('common.something_went_wrong_please_try_again'));
        }

        if ($request->save_type == "save") {
            return redirect()->route('broker.create')->with('success', __('broker.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('broker.index')->with('success', __('broker.create_success'));
        } else {
            return redirect()->route('broker.index')->with('success', __('broker.create_success'));
        }
    }

    public function show($id)
    {
        return redirect()->route('broker.edit', $id);
    }

    public function edit($id)
    {
        $broker = Broker::with('user', 'country','intermediaryDetails')->findOrFail($id);
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] =  $this->common->getStates($broker->country_id);

        $selected_country = $broker->country->name;
        $this->data['isCountryIndia'] = isset($selected_country) && strtolower($selected_country) == 'india' ? true : false;

        $this->data['broker'] = $broker;
        return view('broker.edit', $this->data);
    }

    public function update($id, BrokerRequest $request)
    {
        DB::beginTransaction();
        try {
            $broker = Broker::findOrFail($id);

            $broker_id = $broker->id;

            $input = [
                'company_name' => $request['company_name'],
                // 'first_name' => $request['first_name'],
                // 'middle_name' => $request['middle_name'],
                // 'last_name' => $request['last_name'],
                // 'email' => $request['email'],
                // 'phone_no' => $request['mobile'],
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'pan_no' => $request['pan_no'],
            ];

            $broker->update($input);

            $user = User::findOrFail($broker->user_id);

            $user_input = [
                'email' => $request['email'],
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'mobile' => $request['mobile'],
            ];

            $user->update($user_input);
           
            foreach ($request->intermediaryDetails as $value) {
                $updated_value = collect($value)->except('intermediary_item_id')->toArray();
                $broker->intermediaryDetails()->updateOrCreate(['id'=>$value['intermediary_item_id'] ?? null],$updated_value);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        if ($request->save_type == "save") {
            return redirect()->route('broker.edit',[encryptId($broker_id)])->with('success', __('broker.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('broker.index')->with('success', __('broker.update_success'));
        } else {
            return redirect()->route('broker.index')->with('success', __('broker.update_success'));
        }
    }

    public function destroy($id)
    {
        $broker = Broker::findOrFail($id);
        if($broker)
        {
            $dependency = $broker->deleteValidate($id);
            if(!$dependency)
            {
                $broker->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('broker.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
