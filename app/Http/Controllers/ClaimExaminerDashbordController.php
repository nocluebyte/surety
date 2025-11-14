<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClaimExaminerDashbordController extends Controller
{
      public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('dashboard:claim-examiner');
        // $this->middleware('permission:department.list', ['only' => ['index', 'show']]);
        // $this->middleware('permission:department.add', ['only' => ['create', 'store']]);
        // $this->middleware('permission:department.edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:department.delete', ['only' => ['destroy']]);

        $this->common = new CommonController();
        $this->title = "Dashboard";
        view()->share('title', $this->title);
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('dashboard.claim_examiner.index');
    }
}
