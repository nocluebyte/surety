<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->common = new CommonController();

        $this->title = trans("reports.reports");
        view()->share('title', $this->title);
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
         return view('reports.index');
    }
}
