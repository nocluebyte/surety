<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recovery extends Model
{
    use HasFactory;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","invocation_notification_id","invocation_number","bond_value","total_approved_bond_value","claimed_amount","disallowed_amount","invocation_remark","recover_date","recover_amount","outstanding_amount","remark","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function invocationNotification(){
        return $this->belongsTo(InvocationNotification::class,'invocation_notification_id')
                ->with(['beneficiary','contractor','tender', 'bondPoliciesIssue']);
    }

      //scope
    public function scopeRoleBasedScope($query,$user_role,$user_id){

        return $query->when(isset($user_role) && isset($user_id),function()use($query,$user_role,$user_id){
            
           switch ($user_role) {
            case 'contractor':
                $query->where('invocation_notification.contractor_id',$user_id);
                break;
            case 'claim-examiner':
                $query->where('invocation_notification.claim_examiner_id',$user_id)
                    ->where('invocation_notification.claim_examiner_type','Claim Examiner');
                break;
            case 'beneficiary':
                $query->where('invocation_notification.beneficiary_id',$user_id);
                break;
           }
        
        });
    }
}
