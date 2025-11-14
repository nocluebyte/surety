<?php

namespace App\Http\Controllers;

use Mail;
use Sentinel;
use App\Http\Requests;
use App\Models\{User,Role,UserIp,Beneficiary};
use App\Http\Requests\UserRequest;
use Centaur\AuthManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Centaur\Mail\CentaurWelcomeEmail;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;
use DB;
use Nsure\Helper\Facades\AppHelper;
use Nsure\Services\Permission;
use Auth;
use App\Service\DashboardService;

class UserController extends Controller
{
    /** @var Cartalyst\Sentinel\Users\IlluminateUserRepository */
    protected $userRepository;

    /** @var Centaur\AuthManager */
    protected $authManager;


    public function __construct(AuthManager $authManager)
    {
        // Middleware
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index', 'autologin', 'getEmployeeData']]);
        $this->middleware('permission:users.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:users.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users.delete', ['only' => ['destroy']]);

        // Dependency Injection
        $this->userRepository = app()->make('sentinel.users');
        $this->authManager = $authManager;

        $this->common = new CommonController();
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $except = config('srtpl.users_form_role_except');

        $roles = array_diff($this->common->getRole(),$except);

        $this->data['readonly'] = null;
        $this->data['control_solid'] = null; 
        $this->data['disabled'] = null;
        $this->data['show_create_super_admin'] = true;  
		$this->data['roles'] = $roles;
        $this->data['show_cap_limit_input'] = true;

        return view('admin.users.create',$this->data);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        // dd($request->all());
        // Assemble registration credentials and attributes
        $credentials = [
            'first_name' => $request->get('first_name', null),
            'last_name' => $request->get('last_name', null),
            'email' => trim($request->get('email')),
            'password' => $request->get('password'),
        ];
        $loginUser = Sentinel::getUser();
        $user_id = $loginUser ? $loginUser->id : 0;

        $userData = [
            'claim_examiner_max_approved_limit' => $request->claim_examiner_max_approved_limit ?? null,
            'max_approved_limit'=> $request->max_approved_limit ?? null,
            'individual_cap' => $request->individual_cap ?? null,
            'overall_cap' =>  $request->overall_cap ?? null,
            'group_cap' => $request->group_cap ?? null,
            'is_created_directly'=>1,
            'emp_type' => $request->get('emp_type'),
            'emp_id' => $request->get('emp_id',null),
            'middle_name' => $request->get('middle_name', null),
            'mobile' => $request->get('mobile', null),
            'roles_id' => $request->get('roles_id', null),
            'is_ip_base' => $request->get('is_ip_base', 'No'),
            'ip' => request()->ip(),
            'created_by' => $user_id,
            'is_active' => 'Yes',
        ];        

        $permissions = [];
        $rolePermission = explode(',', $request->get('user_permission'));
        
        foreach ($rolePermission as $permission => $value) {
            if (strlen($value) > 3) {
                $permissions[base64_decode($value)] = true;
            }
        }
        //dd($permissions);
        if (count($permissions) > 0) {
            $userData['permissions'] = json_encode($permissions);
        }

        if(isset($request['make_super_admin'])){
            $permissions['users.superadmin'] = true;
            $userData['permissions'] = json_encode($permissions);
        } else {
            $userData['permissions'] = null;
        }
       

        $file['image'] = '';

        DB::beginTransaction();
		try {
            $activate = true;
            $result = $this->authManager->register($credentials,$activate);
            if ($result->isFailure()) {
				return $result->dispatch;
			}
            $user_id = $result->user->id;

            if ($request->hasFile('image')) {

                $storepath = '/uploads/users/' . $user_id.'/';               
                if (!file_exists($storepath)) {
                    mkdir($storepath, 0777, true);
                }
                $file['image'] = AppHelper::getUniqueFilename($request->file('image'), AppHelper::getImagePath($storepath));
                $request->file('image')->move(AppHelper::getImagePath($storepath), $file['image']);
                $userData['image'] = $file['image'];
                $userData['image_path'] = $storepath.$file['image'];
            }
            $user = User::findOrFail($user_id);
            $user->update($userData);
        
            if (!$activate) {
				$data['code'] = $result->activation->getCode();
				$data['email'] = $result->user->email;
				try {
					
				} catch (Exception $ex) {
					\Log::error($ex);
				}
			}

            $result->user->roles()->sync(array($request->get('roles_id')));

            if (!is_null($request->get('loginips')) && $request->get('is_ip_base')) {
				$loginips_array = $request->get('loginips');
				UserIp::where('user_id', $user_id)->delete();
				foreach ($loginips_array as $key => $value) {
					$ipdata['user_id'] = $user_id;
					$ipdata['login_ip'] = $value['login_ip'];
					UserIp::create($ipdata);
				}
			}

            DB::commit();
		} catch (Exception $e) {
			DB::rollback();
		}
        return redirect()->route('users.index')->with('success', __('common.create_success'));
    }

    /**
     * Display the specified user.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::with(['userIps','rolesData', 'beneficiary','contractor'])->findOrFail($id);
        $this->data['users'] = $users;

        isset($users->beneficiary) ? $users->first_name  = $users->beneficiary->company_name : $users->first_name;

        isset($users->contractor) ? $users->first_name = $users->contractor->company_name : $users->first_name;

        $table_name =  $users->getTable();
        $this->data['table_name'] = $table_name;
        return view('admin.users.show', $this->data);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::with(['userIps'])->findOrFail($id);
        // $roles = Role::pluck('name', 'id')->toArray();
        $users->is_ip_base = ($users->is_ip_base == 'No') ? 0 : 1;
        $userPermissions = $this->getUserPermission($id);
        $role = $users->role;
        $groupPermissions = $this->getPermissionJsonToArray($role->permissions ?? []);
        $groupPermissions = array_keys($groupPermissions);

        $userData = $this->userRepository->findById($id);
        if(isset($users->permissions) && $userData->hasAnyAccess(['users.superadmin'])){
            $users['make_super_admin']  = 1;
        }

        $user_type = Role::where('id', $users->roles_id)->select(['slug'])->first();
		$this->data['user_type'] = $user_type;
		// $this->data['roles'] = $roles;
        // if($users->is_active == 'No'){
        //     $this->data['employees'] = Employee::whereIN('is_active', ['Yes','No'])->orWhere('id',$users->emp_id)
        //     ->select(DB::raw("(CASE WHEN is_active !='Yes' THEN  CONCAT(first_name, ' ', last_name,' - Inactive') ELSE CONCAT(first_name, ' ', last_name,'') END) as person_name"),"id")->pluck('person_name', 'id')->toArray();

        // } else {
		// // $this->data['employees'] = $this->common->getEmployee();
        // }
        $this->data['users'] = $users;
        $this->data['userPermissions'] = $userPermissions;
        $this->data['groupPermissions'] = $groupPermissions;
        
         $except = config('srtpl.users_form_role_except');

        if (in_array($users->role->name,$except)) {
            $this->data['readonly'] = 'readonly';
            $this->data['control_solid'] = 'form-control-solid'; 
            $this->data['disabled'] = 'disabled';
            $this->data['show_create_super_admin'] = false;  
            $this->data['roles'] = $this->common->getRole();
            $this->data['show_cap_limit_input'] = false;
        }
        else{
            $this->data['readonly'] = null;
            $this->data['control_solid'] = null; 
            $this->data['disabled'] = null;
            $this->data['show_create_super_admin'] = true;  
            $this->data['roles'] = array_diff($this->common->getRole(),$except);
            $this->data['show_cap_limit_input'] = true;
        }


       

      

        return view('admin.users.edit', $this->data);

    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        // Validate the form data
        // dd($request->all());
        $beneficiary_company_name = Beneficiary::firstWhere('user_id', $id);
        if(isset($beneficiary_company_name)){
            $beneficiary_company_name->update([
                'company_name' => $request['first_name'],
            ]);
        }
        $validated = $request->validated();

        $attributes = [
			'email' => trim($request->get('email')),
			'first_name' => $request->get('first_name', null),
			'last_name' => $request->get('last_name', null),
		];
        
        $loginUser = Sentinel::getUser();
        $user_id = $loginUser ? $loginUser->id : 0;
	
        $userData = [
            'claim_examiner_max_approved_limit' => $request->claim_examiner_max_approved_limit ?? null,
            'max_approved_limit'=> $request->max_approved_limit ?? null,
            'individual_cap' => $request->individual_cap ?? null,
            'overall_cap' =>  $request->overall_cap ?? null,
            'group_cap' => $request->group_cap ?? null,
            'roles_id'=>$request->roles_id ?? null,
            'emp_type' => $request->get('emp_type'),
            'emp_id' => $request->get('emp_id',null),
            'middle_name' => $request->get('middle_name', null),
            'mobile' => $request->get('mobile', null),
            'is_ip_base' => $request->get('is_ip_base', 'No'),
            'ip' => request()->ip(),
            'updated_by' => $user_id,
            'update_from_ip' => request()->ip(),  
            'allow_multi_login' => $request->get('allow_multi_login', '0'),  
                  
        ];
        // dd($userData);
        $attributes = $request->except(['password', 'password_confirmation']);
		// Do we need to update the password as well?
		if (!empty($request->get('password'))) {
			$userData['password'] = Hash::make($request->get('password'));
		}

        $permissions = [];
        $userData['permissions'] = ""; 
        $rolePermission = explode(',', $request->get('user_permission'));
        
        foreach ($rolePermission as $permission => $value) {
            if (strlen($value) > 3) {
                $permissions[base64_decode($value)] = true;
            }
        }
        
        // Fetch the user object
		$user = $this->userRepository->findById($id);

        if ($user->hasAnyAccess(['users.superadmin']) || isset($request['make_super_admin'])) {
            $permissions['users.superadmin'] = true;
        }
        if (count($permissions) > 0) {
            $userData['permissions'] = json_encode($permissions);
        } 
        //dd($userData['permissions']);
       
        if(!isset($request['make_super_admin']) && $user->hasAnyAccess(['users.superadmin'])){
            $userData['permissions'] = null;
        }

		// Update the user
		$user = $this->userRepository->update($user, $attributes);
        $user->roles()->sync(array($request->get('roles_id')));		
		
		$user_id = $id;
        // $user->roles()->sync(array($request->get('roles_id')));

         //Attachments
         $file['image'] = '';
         if ($request->hasFile('image')) { 
             $storepath = '/uploads/users/' . $user_id.'/';               
             if (!file_exists($storepath)) {
                 mkdir($storepath, 0777, true);
             }
             $file['image'] = AppHelper::getUniqueFilename($request->file('image'), AppHelper::getImagePath($storepath));
             $request->file('image')->move(AppHelper::getImagePath($storepath), $file['image']);
             $userData['image'] = $file['image'];
             $userData['image_path'] = $storepath.$file['image'];
         }

        $user = User::findOrFail($user_id);
       
        $user->update($userData);
		
        if (!is_null($request->get('loginips')) && $request->get('is_ip_base')) {
            $loginips_array = $request->get('loginips');
            UserIp::where('user_id', $user_id)->delete();
            foreach ($loginips_array as $key => $value) {
                $ipdata['user_id'] = $user_id;
                $ipdata['login_ip'] = $value['login_ip'];
                UserIp::create($ipdata);
            }
        } else {
            UserIp::where('user_id', $user_id)->delete();
        }

        return redirect()->route('users.index')->with('success', __('common.update_success'));
    }

    public function getEmployeeData(Request $request)
    {
        $employeeData = Employee::with('employeeAddress')->where('id',$request->emp_id)->first();
        return  $employeeData;
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    /* public function destroy(Request $request, $id)
    {
        // Fetch the user object
        //$id = $this->decode($hash);
        $user = $this->userRepository->findById($id);

        // Check to be sure user cannot delete himself
        if (Sentinel::getUser()->id == $user->id) {
            $message = "You cannot remove yourself!";

            if ($request->expectsJson()) {
                return response()->json($message, 422);
            }
            session()->flash('error', $message);
            return redirect()->route('users.index');
        }

        // Remove the user
        $user->delete();

        // All done
        $message = "{$user->email} has been removed.";
        if ($request->expectsJson()) {
            return response()->json([$message], 200);
        }

        session()->flash('success', $message);
        return redirect()->route('users.index');
    } */

    /**
     * Decode a hashid
     * @param  string $hash
     * @return integer|null
     */
    // protected function decode($hash)
    // {
    //     $decoded = $this->hashids->decode($hash);

    //     if (!empty($decoded)) {
    //         return $decoded[0];
    //     } else {
    //         return null;
    //     }
    // }

    public function getPermissionJsonToArray($permission = [])
    {
        $data = [];
        $i = 0;
        foreach ($permission as $permission_key => $permission_value) {
            $permi = explode('.', $permission_key);
            $data[base64_encode($permission_key)] = $permission_value;
        }
        return $data;
    }

    public function getPermissionArrayToNameWise($permission = [])
    {
        $data = [];
        foreach ($permission as $permission_key => $permission_array) {
            foreach ($permission_array as $permission_name => $permission_value) {
                $permi = explode('.', $permission_value);
                $data[$permi[0]][$permission_name] = array(
                    'permission' => base64_encode($permission_value),
                    'label' => $permi[1],
                    'can_inherit' => -1,
                );
            }
        }
        return $data;
    }

    public function getUserPermission($userId) {
        $permissionArr = $userPermission = $groupPermissions = [];
        $user = User::find($userId);
        $allPermission = $this->getPermissionArrayToNameWise((new Permission)->getPermissions());
        $role = $user->role;
        if ($role) {
            $groupPermissions = $this->getPermissionJsonToArray($role->permissions);
        }
        if (!empty($user->permissions)) {
            $userPermission = $this->getPermissionJsonToArray(json_decode($user->permissions, true));
        }
        $userPermission = array_merge($userPermission, $groupPermissions);
        $cardWisePerm = [
            'users' => 'Side Panel',
            'country' => 'Master', 
            'HRM' => 'Report', 
            'rm_category' => 'Purchase', 
            'group_of_companies' => 'Sales', 
            'recipe' => 'Production', 
            'employee' => 'HRM', 
            'item_category' => 'Store', 
            'chart_of_account' => 'Account', 
        ];
        $index = $ind = $i = 1;
        if (count($allPermission) > 0) {
            $groupName = "";
            foreach ($allPermission as $group => $permission) {
                $subItems = [];
                if (count($permission) > 0) {
                    foreach ($permission as $per) {
                        $isSelected = false;
                        if (array_key_exists($per['permission'],$userPermission)) {
                            $isSelected = true;
                        }
                        $subItems[] = [
                            'id'                => $per['permission'],
                            'text'              => $per['label'],
                            'spriteCssClass'    => 'html',
                            'checked'           => $isSelected,
                        ];
                    }
                }
                $items = [
                    'id'                => $ind,
                    'text'              => $group,
                    'expanded'          => false,
                    'spriteCssClass'    => 'folder',
                    'items'             => $subItems, 
                ];
                if (array_key_exists($group, $cardWisePerm)) {
                    $groupName = $group;
                    $permissionArr[$group] = [
                        'id'                => $index,
                        'text'              => $cardWisePerm[$group],
                        'expanded'          => false,
                        'spriteCssClass'    => 'rootfolder',
                        'items'             => [$items]
                    ];
                    $index++;
                } else {
                    array_push($permissionArr[$groupName]['items'], $items);
                }
                $ind++;
            }
        }
        
        return $permissionArr;
    }

    public function autologin(DashboardService $dashboardService,Request $request, $id, $back_login='')
    {
        try {  
            if($back_login){
                $request->session()->forget('back_login_id');
            }
            $loginUser = Sentinel::getUser();
            $user_id = $loginUser ? $loginUser->id : 0;     
            $user = Sentinel::findById($id);
            if ($user) {
                if(!$back_login){
                    $request->session()->put('back_login_id', $user_id); 
                    $request->session()->save();    
                }

                Sentinel::login($user);
                if (Sentinel::check()) {              
                    return redirect()->route($dashboardService->getDashboard());
                }

                return redirect()->back();
            }
        } catch (\Exception $e) {
            \Log::info($e);
            session()->flash('error', 'User not found!');
            return redirect()->route('users.index');
        }
    }
}
