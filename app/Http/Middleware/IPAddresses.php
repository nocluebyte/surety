<?php

namespace App\Http\Middleware;

use Closure;
use Centaur\AuthManager;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Session;

class IPAddresses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ( $user ){
            $user_id = $user->id;
            $is_ip_base = $user->is_ip_base;
            if ($is_ip_base == 'Yes') {
                $currentIP = \Request::ip();
                $allowIPArr = DB::table('user_ips')->where('user_id', $user_id)->whereNull('deleted_at')->get()->pluck('login_ip')->toArray();
                if (!in_array($currentIP, $allowIPArr)) {
                    Session::put('error',trans('Access denied due to user not allowed from this network.'));
                    $this->authManager->logout(null, null);
                }
            }
        }
        return $next($request);
    }
}