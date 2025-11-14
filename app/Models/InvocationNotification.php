<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\morphMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class InvocationNotification extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'invocation_notification';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","proposal_id","bond_policies_issue_id","version","bond_type_id","claim_examiner_type","claim_examiner_id","claim_examiner_assigned_date","invocation_date","bond_number","contractor_id","beneficiary_id","tender_id","project_details_id","bond_start_date","bond_end_date","bond_conditionality","invocation_amount","total_recoverd_amount","total_outstanding_amount","claimed_amount","disallowed_amount","total_approved_bond_value","invocation_ext","officer_name","officer_designation","officer_email","officer_mobile","officer_land_line","incharge_name","incharge_designation","incharge_email","incharge_mobile","incharge_land_line","office_branch","office_address","reason_for_invocation","reason","remark","status","payout_remark","cancellelation_reason_id","closed_reason","is_amendment","is_claim_converted","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function dmsamend(): MorphTo{
        return $this->morphTo();
    }
    public function dMS(): MorphMany{
        return $this->morphMany(DMS::class,'dmsable');
    }
    public function bondType(){
        return $this->belongsTo(BondTypes::class,'bond_type_id');
    }
    public function proposal(){
        return $this->belongsTo(Proposal::class,'proposal_id','id');
    }
    public function performanceBond(){
        return $this->belongsTo(PerformanceBond::class,'bond_id','id');
    }

    public function cases(): morphMany
    {
        return $this->morphMany(Cases::class, 'casesable');
    }

    public function beneficiary(){
        return $this->belongsTo(Beneficiary::class,'beneficiary_id');
    }

    public function contractor(){
        return $this->belongsTo(Principle::class,'contractor_id');
    }

    public function tender(){
        return $this->belongsTo(Tender::class,'tender_id');
    }

    public function projectDetails(){
         return $this->belongsTo(ProjectDetail::class,'project_details_id');
    }

    public function recovery(){
        return $this->hasMany(Recovery::class,'invocation_notification_id');
    }

    public function claimExaminerLog(){
        return $this->hasMany(InvocationNotificationClaimExaminerLog::class,'invocation_notification_id')->with(['claimExaminer','createdBy'])->orderByDesc('id');
    }

    // public function claimExaminer (){
    //     return $this->belongsTo(ClaimExaminer::class,'claim_examiner_id')->with('user');
    // }

    public function cancellelationReason(){
        return $this->belongsTo(InvocationReason::class,'cancellelation_reason_id');
    }

    public function bondPoliciesIssue(){
        return $this->belongsTo(BondPoliciesIssue::class,'bond_policies_issue_id');
    }

    public function analysis(){
        return $this->hasMany(InvocationNotificationAnalysis::class);
    }

    public function invocationNotificationHistory(){
        return $this->hasMany(InvocationNotification::class,'contractor_id','contractor_id');
    }

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


    public function claimExaminer()
    {
        return $this->morphTo();
    }

    public function claimExaminerUserId(): Attribute{
        return Attribute::make(
            get:fn() => $this->claim_examiner_type === 'Claim Examiner' ? $this->claimExaminer->user_id : $this->claimExaminer->id ?? null
        );
    }

    public function assignedClaimExaminerName(): Attribute {
        return Attribute::make(
            function() {
                if($this->claim_examiner_type == 'Claim Examiner' && $this->claimExaminer?->user) {
                    return $this->claimExaminer->user->full_name;
                }

                if($this->claim_examiner_type == 'User' && $this->claimExaminer) {
                    return $this->claimExaminer->full_name;
                }
            }
        );
    }

}
