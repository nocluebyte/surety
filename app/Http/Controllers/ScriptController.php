<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
    BondPoliciesIssue,
    Proposal,
};
use App\Http\Requests;

class ScriptController extends Controller
{
    public function runScript()
    {
        BondPoliciesIssue::leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')
        ->where('proposals.version', '>', 1)
        ->where([
            'proposals.is_amendment' => 1,
            'bond_policies_issue.is_amendment' => 0,
        ])
        ->update(['bond_policies_issue.is_amendment' => 1]);

        Proposal::where([
            'status' => 'Issued',
            'is_invocation_notification' => 1,
        ])->update(['status' => 'Invoked']);

        dd('Data updated succesfully');
    }
}
