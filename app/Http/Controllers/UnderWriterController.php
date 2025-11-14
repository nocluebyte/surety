<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\UnderWriter;
use App\Models\{Country,State, User, Role, RoleUser};
use App\Http\Requests\UnderWriterRequest;
use App\DataTables\UnderWriterDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Centaur\AuthManager;
use Sentinel;
use Carbon\Carbon;
use App\Exceptions\MailTemplateException;
use Illuminate\Support\Str;

class UnderWriterController extends Controller
{
    public function __construct(AuthManager $authManager)
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:underwriter.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:underwriter.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:underwriter.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:underwriter.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('underwriter.underwriter');
        view()->share('title', $this->title);

        $this->authManager = $authManager;
    }

    public function index(UnderWriterDataTable $datatable)
    {
        $underwriter_filter = Config('srtpl.filters.underwriter_filter');
        $this->data['underwriter_type'] = $underwriter_filter['underwriter_type'];
        $this->data['underwriter_status'] = $underwriter_filter['underwriter_status'];

        return $datatable->render('underwriter.index', $this->data);
    }

    public function create()
    {
        $this->data['type'] = Config('srtpl.filters.underwriter_filter.underwriter_type');
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] = [];
        if (old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }
        $this->data['isCountryIndia'] = true;

        return view('underwriter.create', $this->data);
    }

    public function store(UnderWriterRequest $request)
    {
        $check_entry = UnderWriter::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->email == $request['email'])) {
            return redirect()->route('underwriter.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try {
            $generateOtp = $this->common->generateRandumCodeEmail();

            $roleUnderwriter = Str::slug($request->type, '-');

            $roleId = Role::where('slug', $roleUnderwriter)->value('id');
            if(!isset($roleId)){
                return redirect()->route('underwriter.create')->with('error', 'Role Not Found, Please Check the Role List');
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
                'type' => $request['type'],
                // 'email' => $request['email'],
                // 'phone_no' => $request['phone_no'],
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'pan_no' => $request['pan_no'],
                'user_id' => $user_id,
                'max_approved_limit' => $request['max_approved_limit'],
                'individual_cap' => $request['individual_cap'],
                'overall_cap' => $request['overall_cap'],
                'group_cap' => $request['group_cap'],
            ];

            $model = UnderWriter::create($input);

            // $this->common->sendMail('login_details', $request['email'], $generateOtp, $request['first_name']);

            DB::commit();
        }
        catch (MailTemplateException $th) {
            DB::rollback();
            return redirect()->route('underwriter.create')->with('error', $th->getMessage());
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('underwriter.create')->with('error', __('common.something_went_wrong_please_try_again'));
        }

        if ($request->save_type == "save") {
            return redirect()->route('underwriter.create')->with('success', __('underwriter.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('underwriter.index')->with('success', __('underwriter.create_success'));
        } else {
            return redirect()->route('underwriter.index')->with('success', __('underwriter.create_success'));
        }
    }

    public function show($id)
    {
        $underwriter = UnderWriter::findOrFail($id);
        $table_name =  $underwriter->getTable();
        $this->data['table_name'] = $table_name;
        $this->data['underwriter'] = $underwriter;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($underwriter->country_id);
        return view('underwriter.show',$this->data);
    }

    public function edit($id)
    {
        $underwriter = UnderWriter::with('user', 'country')->findOrFail($id);
        $this->data['type'] = Config('srtpl.filters.underwriter_filter.underwriter_type');
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] =  $this->common->getStates($underwriter->country_id);

        $selected_country = $underwriter->country->name;
        $this->data['isCountryIndia'] = isset($selected_country) && strtolower($selected_country) == 'india' ? true : false;

        $this->data['underwriter'] = $underwriter;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($underwriter->country_id);
        return view('underwriter.edit', $this->data);
    }

    public function update($id, UnderWriterRequest $request)
    {
        DB::beginTransaction();
        try {
            $underwriter = UnderWriter::findOrFail($id);

            $underwriter_id = $underwriter->id;

            $input = [
                'company_name' => $request['company_name'],
                // 'first_name' => $request['first_name'],
                // 'middle_name' => $request['middle_name'],
                // 'last_name' => $request['last_name'],
                'type' => $request['type'],
                // 'email' => $request['email'],
                // 'phone_no' => $request['phone_no'],
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'pan_no' => $request['pan_no'],
                'max_approved_limit' => $request['max_approved_limit'],
                'individual_cap' => $request['individual_cap'],
                'overall_cap' => $request['overall_cap'],
                'group_cap' => $request['group_cap'],
            ];

            $underwriter->update($input);

            $user = User::findOrFail($underwriter->user_id);

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
            return redirect()->route('underwriter.index')->with('error', __('common.something_went_wrong_please_try_again'));
            
        }

        if ($request->save_type == "save") {
            return redirect()->route('underwriter.edit',[encryptId($underwriter_id)])->with('success', __('underwriter.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('underwriter.index')->with('success', __('underwriter.update_success'));
        } else {
            return redirect()->route('underwriter.index')->with('success', __('underwriter.update_success'));
        }
    }

    public function destroy($id)
    {
        $underwriter = UnderWriter::findOrFail($id);
        if($underwriter)
        {
            $dependency = $underwriter->deleteValidate($id);
            if(!$dependency)
            {
                $underwriter->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('underwriter.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
