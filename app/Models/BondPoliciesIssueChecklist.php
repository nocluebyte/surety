<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BondPoliciesIssueChecklist extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'bond_policies_issue_checklist';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","proposal_id","version","contractor_id","bond_type","premium_amount","past_premium","net_premium","utr_neft_details","date_of_receipt","booking_office_detail","executed_deed_indemnity","deed_remarks","executed_board_resolution","board_remarks","broker_mandate","intermediary_detail_id","intermediary_detail_type","intermediary_detail_code","intermediary_detail_name","intermediary_detail_email","intermediary_detail_mobile","intermediary_detail_address","collateral_available","collateral_remarks","fd_amount","fd_issuing_bank_name","fd_issuing_branch_name","fd_receipt_number","bank_address","is_amendment","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function contractor(){
        return $this->hasOne(Principle::class, 'id', 'contractor_id');
    }

    public function scopeRoleBasedScope($query,$user_role,$user_id){

        return $query->when(isset($user_role) && isset($user_id),function()use($query,$user_role,$user_id){
            
           switch ($user_role) {
            case 'contractor':
                $query->where('bond_policies_issue_checklist.contractor_id',$user_id);
                break;
           }
        
        });
    }

    public function proposal(){
        return $this->hasOne(Proposal::class, 'id','proposal_id');
    }
}
