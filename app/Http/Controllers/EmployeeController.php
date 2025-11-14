<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Employee;
use App\Models\{Country,State, User, Role, DMS};
use App\Http\Requests\EmployeeRequest;
use App\DataTables\EmployeeDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Centaur\AuthManager;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Exceptions\MailTemplateException;

class EmployeeController extends Controller
{
    protected $authManager;

    public function __construct(AuthManager $authManager)
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:employee.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:employee.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:employee.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:employee.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('employee.employee');
        view()->share('title', $this->title);

        $this->authManager = $authManager;
    }

    public function index(EmployeeDataTable $datatable)
    {
        $this->data['designation_id'] =  $this->common->getDesignation();
        return $datatable->render('employee.index', $this->data);
    }

    public function create()
    {
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] =  [];
        if (old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }
        $this->data['designation_id'] =  $this->common->getDesignation();
        return view('employee.create', $this->data);
    }

    public function store(EmployeeRequest $request)
    {
        $check_entry = Employee::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->post_code == $request['post_code'])) {
            return redirect()->route('employee.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        DB::beginTransaction();
        try {
            $generateOtp = $this->common->generateRandumCodeEmail();

            $roleId = Role::where('slug', 'employee')->value('id');
            if(!isset($roleId)){
                return redirect()->route('employee.create')->with('error', 'Role Not Found, Please Check the Role List');
            }

            $loginUser = Sentinel::getUser();
            $user_id = $loginUser ? $loginUser->id : 0;

            $role_details = Role::findOrFail($roleId);
            $role_permissions = $role_details->permissions;
            $role_permissions = is_array($role_permissions) ? json_encode($role_permissions) : $role_permissions;

            if (!is_string($role_permissions)) {
                throw new \Exception('Role permissions are not in the correct format');
            }

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

            $employee_input = [
                'user_id' => $user_id,
                'address' => $request['address'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'city' => $request['city'],
                'post_code' => $request['post_code'],
                'designation_id' => $request['designation_id'],
            ];

            $employee = Employee::create($employee_input);
            $employee_id = $employee->id;

            $this->common->storeMultipleFiles($request, $request['photo'], 'photo', $employee, $employee_id, 'employee');

            // $this->common->sendMail('login_details', $request['email'], $generateOtp, $request['first_name']);

            DB::commit();
        }
        catch (MailTemplateException $th) {
            DB::rollback();
            return redirect()->route('employee.create')->with('error', $th->getMessage());
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('employee.create')->with('error', __('common.something_went_wrong_please_try_again'));
        }

        if ($request->save_type == "save") {
            return redirect()->route('employee.create')->with('success', __('employee.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('employee.index')->with('success', __('employee.create_success'));
        } else {
            return redirect()->route('employee.index')->with('success', __('employee.create_success'));
        }
    }

    public function show($id)
    {
        return redirect()->route('employee.edit', $id);
    }

    public function edit($id)
    {
        $employee = Employee::with('userEmployee', 'dMS')->findOrFail($id);

        $this->data['user_data'] = $employee->userEmployee;
        $this->data['dms_data'] = $employee->dMS;

        $this->data['countries'] =  $this->common->getCountries($employee->country_id);
        $this->data['states'] =  $this->common->getStates($employee->country_id);
        $this->data['designation_id'] =  $this->common->getDesignation($employee->designation_id);
        $this->data['employee'] = $employee;
        return view('employee.edit', $this->data);
    }

    public function update($id, EmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::findOrFail($id);

            $employee_id = $employee->id;

            $input = [
                'address' => $request['address'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'city' => $request['city'],
                'post_code' => $request['post_code'],
                'designation_id' => $request['designation_id'],
            ];

            $employee->update($input);

            $user = User::findOrFail($employee->user_id);

            $user_input = [
                'email' => $request['email'],
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'mobile' => $request['mobile'],
            ];

            $user->update($user_input);

            if($request['photo']){
                $this->common->updateMultipleFiles($request, $request['photo'], 'photo', $employee, $employee_id, 'employee');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        if ($request->save_type == "save") {
            return redirect()->route('employee.edit',[encryptId($employee_id)])->with('success', __('employee.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('employee.index')->with('success', __('employee.update_success'));
        } else {
            return redirect()->route('employee.index')->with('success', __('employee.update_success'));
        }
    }

    public function destroy($id)
    {
        $employee = Employee::with('dMS')->findOrFail($id);

        $dms_data = DMS::where('dmsable_id', $id);

        if($employee)
        {
            $dependency = $employee->deleteValidate($id);
            if(!$dependency)
            {
                foreach($dms_data->pluck('attachment') as $dms_item)
                {
                    File::delete($dms_item);
                }

                $employee->dMS()->delete();
                $employee->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('employee.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
