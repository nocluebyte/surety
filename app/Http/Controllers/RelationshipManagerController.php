<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\RelationshipManager;
use App\Models\{Country,State, User, Role};
use App\Http\Requests\RelationshipManagerRequest;
use App\DataTables\RelationshipManagerDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Centaur\AuthManager;
use Sentinel;
use Carbon\Carbon;
use App\Exceptions\MailTemplateException;

class RelationshipManagerController extends Controller
{
    protected $authManager;

    public function __construct(AuthManager $authManager)
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:relationship_manager.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:relationship_manager.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:relationship_manager.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:relationship_manager.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('relationship_manager.relationship_manager');
        view()->share('title', $this->title);

        $this->authManager = $authManager;
    }

    public function index(RelationshipManagerDataTable $datatable)
    {
        return $datatable->render('relationship_manager.index');
    }

    public function create()
    {
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] = [];
        if (old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }
        $this->data['users'] = $this->common->getUserByType('beneficiary');
        $this->data['rmUsersOptions'] = [];
        return view('relationship_manager.create', $this->data);
    }

    public function store(RelationshipManagerRequest $request)
    {
        // dd($request->all());
        $check_entry = RelationshipManager::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->post_code == $request['post_code'])) {
            return redirect()->route('relationship_manager.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try {
            $generateOtp = $this->common->generateRandumCodeEmail();

            $roleId = Role::where('slug', 'rm-' . $request->type)->value('id');
            if(!isset($roleId)){
                return redirect()->route('relationship_manager.create')->with('error', 'Role Not Found, Please Check the Role List');
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
            ];

            $model = RelationshipManager::create($input);

            $rmUsers = $request->rmUsers;
            if (!empty($rmUsers) && count($rmUsers) > 0) {
                foreach ($rmUsers as $row) {
                    $rmUsersArr = [
                        'rm_user_id' => $model->user_id,
                        'user_id' => $row['rm_user_id'] ?? NULL,
                    ];
                    $model->user->rmUsers()->create($rmUsersArr);
                }
            }

            // $this->common->sendMail('login_details', $request['email'], $generateOtp, $request['first_name']);

            DB::commit();
        }
        catch (MailTemplateException $th) {
            DB::rollback();
            return redirect()->route('relationship_manager.create')->with('error', $th->getMessage());
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('relationship_manager.create')->with('error', __('common.something_went_wrong_please_try_again'));
        }

        if ($request->save_type == "save") {
            return redirect()->route('relationship_manager.create')->with('success', __('relationship_manager.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('relationship_manager.index')->with('success', __('relationship_manager.create_success'));
        } else {
            return redirect()->route('relationship_manager.index')->with('success', __('relationship_manager.create_success'));
        }
    }

    public function show($id)
    {
        return redirect()->route('relationship_manager.edit', $id);
    }

    public function edit($id)
    {
        $relationship_manager = RelationshipManager::with('user.rmUsers.user')->findOrFail($id);
        $this->data['countries'] =  $this->common->getCountries($relationship_manager->country_id);
        $this->data['states'] =  $this->common->getStates($relationship_manager->country_id);
        $this->data['relationship_manager'] = $relationship_manager;
        $users = $this->common->getUserByType('beneficiary');
        $rmuserArr = $relationship_manager->user->rmUsers->pluck('user_id')->toArray();
        $rmUsersOptions = [];
        if (!empty($users)) {
            foreach ($users as $key => $val) {
                if(in_array($key,$rmuserArr)){
                    $rmUsersOptions[$key] = ['disabled' => 'disabled'];
                }
            }
        }
        $this->data['rmUsersOptions'] = $rmUsersOptions;
        $this->data['users'] = $users;
        $this->data['rmUsers'] = $relationship_manager->user->rmUsers;
        // dd($relationship_manager->user->rmUsers);
        return view('relationship_manager.edit', $this->data);
    }

    public function update($id, RelationshipManagerRequest $request)
    {
        DB::beginTransaction();
        try {
            $relationship_manager = RelationshipManager::findOrFail($id);

            $relationship_manager_id = $relationship_manager->id;

            $input = [
                'address' => $request['address'],
                'city' => $request['city'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'post_code' => $request['post_code'],
            ];

            $relationship_manager->update($input);

            $user = User::findOrFail($relationship_manager->user_id);

            $user_input = [
                'email' => $request['email'],
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'mobile' => $request['mobile'],
            ];

            $user->update($user_input);

            $rmUsers = $request->rmUsers;
            $rm_ids = collect($rmUsers)->pluck('rm_user_item_id')->toArray();
            $existing_rm_users = $relationship_manager->user->rmUsers()->pluck('id')->toArray();
            $diff_users = array_diff($existing_rm_users, $rm_ids);
            $relationship_manager->user->rmUsers()->whereIn('id', $diff_users)->get()->each(function ($item) {
                $item->delete();
            });
            if (!empty($rmUsers) && count($rmUsers) > 0) {
                foreach ($rmUsers as $row) {
                    $rmUsersArr = $relationship_manager->user->rmUsers()->updateOrCreate([
                        'id'=>$row['rm_user_item_id'] ?? null
                    ],[
                        'rm_user_id' => $relationship_manager->user_id,
                        'user_id' => $row['rm_user_id'] ?? NULL,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        if ($request->save_type == "save") {
            return redirect()->route('relationship_manager.edit',[encryptId($relationship_manager_id)])->with('success', __('relationship_manager.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('relationship_manager.index')->with('success', __('relationship_manager.update_success'));
        } else {
            return redirect()->route('relationship_manager.index')->with('success', __('relationship_manager.update_success'));
        }
    }

    public function destroy($id)
    {
        $relationship_manager = RelationshipManager::findOrFail($id);
        if($relationship_manager)
        {
            $dependency = $relationship_manager->deleteValidate($id);
            if(!$dependency)
            {
                $relationship_manager->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('relationship_manager.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
}
