<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralDashboardController extends Controller
{
     public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->title = "Dashboard";
        view()->share('title', $this->title);
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('dashboard.general.index');
    }
}
