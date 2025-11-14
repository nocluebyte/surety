<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\DashboardService;

class DashboardMiddleware
{
    private $dashboardService;
     public function __construct(DashboardService $dashboardService){
		$this->dashboardService  = $dashboardService;
	 }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$dashboardrole): Response
    {

        $role = $this->dashboardService->getCurrentUserRole();

        $dashboardrole = explode(',',$dashboardrole);

        if (in_array($role,$dashboardrole)) {
             return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
