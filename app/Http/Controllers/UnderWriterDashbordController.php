<?php

namespace App\Http\Controllers;

use App\Models\{
    Proposal,
    UnderWriter,
    Cases,
    Principle
};
use Illuminate\Http\Request;

class UnderWriterDashbordController extends Controller
{
       public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('dashboard:risk-underwriter,commercial-underwriter');
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
    public function __invoke()
    {
        $underwriter = UnderWriter::firstWhere('user_id', $this->user?->id);

        //Application Count
        $cases_application_count = Cases::RoleBasedScope($this->current_user_role,$underwriter->id)
        ->Pending()
        ->where('case_type','Application')
        ->count();

        $this->data['cases_application_count'] = $cases_application_count;
        
        //Review Count
        $cases_review_count =  Cases::RoleBasedScope($this->current_user_role,$underwriter->id)
        ->Pending()
        ->where('case_type','Review')
        ->count();
         $this->data['cases_review_count'] = $cases_review_count;

        //Contractor Count
        $contractor_count = Principle::count();
        $this->data['contractor_count'] = $contractor_count;

        // Total Bonds
        $bond_count = Proposal::where([
            'is_issue'=>1,	
            // 'is_amendment'=>0,
            'is_invocation_notification'=>0,	
            'is_bond_foreclosure'=>0,	
            'is_bond_cancellation'=>0,
        ])
        ->count();
        $this->data['bond_count'] = $bond_count;

        //Today Application
        $todays_application = Cases::with(['contractor:id,company_name','beneficiary:id,company_name'])
        ->Pending()
        ->where('underwriter_id', $underwriter->id)
        ->where('case_type', 'Application')
        ->whereDate('underwriter_assigned_date',now())
        ->get();
         $this->data['todays_application'] = $todays_application;

        //Today Review
        $todays_review = Cases::with(['contractor:id,company_name','beneficiary:id,company_name'])
        ->Pending()
        ->where('underwriter_id', $underwriter->id)
        ->where('case_type', 'Review')
        ->whereDate('underwriter_assigned_date',now())
        ->get();
         $this->data['todays_review'] = $todays_review;
        
    

        return view('dashboard.underwriter.index',$this->data);
    }
}
