<?php

namespace App\Http\Controllers\Auth;

use Sentinel;
use Centaur\AuthManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Centaur\Dispatches\BaseDispatch;
use App\Models\Year;
use Illuminate\Support\Facades\Session;
use DB;
use App\Service\DashboardService;
use App\Rules\ReCaptcha;
use File;

class SessionController extends Controller
{
    /** @var Centaur\AuthManager */
    protected $authManager;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(AuthManager $authManager)
    {
        $this->middleware('sentinel.guest', ['except' => 'getLogout']);
        $this->authManager = $authManager;
    }

    /**
     * Show the Login Form
     * @return View
     */
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle a Login Request
     * @return Response|Redirect
     */
    public function postLogin(Request $request,DashboardService $dashboardService) {
        // Validate the Form Data
        $result = $this->validate($request, [
            'g-recaptcha-response' => ['required', new ReCaptcha],
            'email' => 'required',
            'password' => 'required'],
            [
                'email.required' => trans("module_validation.email_required"),
                'password.required' => trans("module_validation.password_required"),
                'g-recaptcha-response.required' => 'This field is required',
            ]
        );

        // Assemble Login Credentials
        $credentials = array(
            'login' => str_replace(' ', '', $request->get('email')),
            'password' => $request->get('password'),
        );
        
        $remember = (bool) $request->get('remember', false);

        // $user = Sentinel::findById(1);
        // Sentinel::login($user);
        // Attempt the Login
        $result = $this->authManager->authenticate($credentials, $remember);

        $user = Sentinel::getUser();
        if($user){
            $user_id = $user->id;
            $is_ip_base = $user->is_ip_base;
            
            if($user->is_active == "No"){
                Session::put('error',trans('Access denied due to user not activated.'));
                $this->authManager->logout(null, null);
                $route = 'auth.login.form';
            } else if ($is_ip_base == 'Yes') {
                $currentIP = \Request::ip();
                $allowIPArr = DB::table('user_ips')->where('user_id', $user_id)->whereNull('deleted_at')->get()->pluck('login_ip')->toArray();

                if (!in_array($currentIP, $allowIPArr)) {
                    Session::put('error',trans('Access denied due to user not allowed from this network.'));
                    $this->authManager->logout(null, null);
                    $route = 'auth.login.form';
                } else {
                    Session::forget('error');
                }
            } else {
                Session::forget('error');
            }
        }

        $route = 'dashboard';
        if($result->statusCode === 200){            
            $default_year = Year::where('is_default','Yes')->first();
            Session::put('default_year',$default_year);            
            /*if($user->hasAnyAccess(['users.superadmin', 'users.admin_dashboard'])){
                $route = 'admin-dashboard'; */
           // }else{
                // $this->authenticated($request, $user);
            
                // if ($user->roles->first()->slug == 'contractor') {
                //    $route = 'dashboard.contractor';
                // }

                $route = $dashboardService->getDashboard();
            //}
        }else{
            $this->authManager->logout(null, null);
            $route = 'auth.login.form';
        }
       
        // Return the appropriate response
        $path = session()->pull('url.intended', route($route));
        return $result->dispatch($path);
    }

    /**
     * Handle a Logout Request
     * @return Response|Redirect
     */
    public function getLogout(Request $request)
    {
        // Terminate the user's current session.  Passing true as the
        // second parameter kills all of the user's active sessions.
        $result = $this->authManager->logout(null, null);
        // Return the appropriate response
        return $result->dispatch(route('auth.login.form'));
    }
    protected function translate($key, $message)
    {
        $key = 'centaur.' . $key;

        if (Lang::has($key)) {
            $message = trans($key);
        }

        return $message;
    }
}
