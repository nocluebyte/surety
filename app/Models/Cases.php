<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;



Relation::MorphMap([
    'Beneficiary' => Beneficiary::class,
    'Principle'=>Principle::class,
    'Proposal'=>Proposal::class,
    'PerformanceBond'=>PerformanceBond::class,
    'BidBond'=>BidBond::class,
    'AdvancePaymentBond'=>AdvancePaymentBond::class,
    'RetentionBond'=>RetentionBond::class,
    'MaintenanceBond'=>MaintenanceBond::class,
    'Cases'=>Cases::class,
    'User'=>User::class   ,
    'Underwriter'=>UnderWriter::class
]);
class Cases extends MyModel
{
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = [
        "id","casesable_type","casesable_id","contractor_id","beneficiary_id","proposal_code","proposal_id","proposal_parent_id","tender_id","bond_type_id","bond_start_date","bond_end_date","bond_period","bond_value","previous_bond_value","contract_value","case_type","underwriter_id","underwriter_type","underwriter_assigned_date","status","decision_status","nbi_status","tender_evaluation","project_acceptable_remark","project_acceptable","transfer_decision_notes","transfer_date","last_bs_date","decision_taken_date","decision_draft_taken_date","cases_action_amendment_type","cases_action_reason_for_submission","cases_action_adverse_notification","cases_action_adverse_notification_remark","cases_action_beneficiary_acceptable","cases_action_beneficiary_acceptable_remark","cases_action_audited","cases_action_consolidated","cases_action_currency_id","cases_action_bond_invocation","cases_action_bond_invocation_remark","cases_action_blacklisted_contractor","cases_action_blacklisted_contractor_remark","project_details_current_status_of_the_project","project_details_any_updates","contractor_rating","uw_view_id","contractor_rating_date","is_amendment","is_current","is_bond_managment_action_taken","bond_managment_action_type","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function casesable(): MorphTo{
        return $this->morphTo();
    }

    public function dMS(): MorphMany{
        return $this->morphMany(DMS::class,'dmsable');
    }
    public function caseActionPlan(){
        return $this->hasMany(CasesActionPlan::class,'cases_id','id');
    }
    public function underwriter()
    {
        return $this->morphTo();
    }
    public function bondType(){
        return $this->belongsTo(BondTypes::class,'bond_type_id');
    }

    public function proposal(){
        return $this->belongsTo(Proposal::class,'proposal_id');
    }
    public function beneficiary(){
        return $this->belongsTo(Beneficiary::class,'beneficiary_id');
    }

    public function tender(){
        return $this->belongsTo(Tender::class,'tender_id');
    }
    public function contractor(){
        return $this->belongsTo(Principle::class, 'contractor_id');
    }

    public function casesDecision(){
        return $this->hasOne(CasesDecision::class,'cases_id');
    }

    public function casesDecisionContractor(){
        return $this->hasMany(CasesDecision::class,'contractor_id','contractor_id');
    }
    public function underwriter_log(){
        return $this->morphMany(UnderwriterCasesLog::class,'casesable');
    }

    //accesser 
    public function underwriterUserName() : Attribute   {
        return Attribute::make(
            get: function () {
            if ($this->underwriter_type === 'User' && $this->underwriter) {
                return $this->underwriter->full_name;
            }

            if ($this->underwriter_type === 'Underwriter' && $this->underwriter?->user) {
                return $this->underwriter->user->full_name;
            }

            return null;
        } 
        );
    }

    public function isCaseAmend(): Attribute{
        return Attribute::make(
            get:fn() => $this->proposal_id ===  $this->proposal_parent_id ? false : true
        );
    }
    public function underwriterUserId(): Attribute{
        return Attribute::make(
            get:fn() => $this->underwriter_type === 'Underwriter' ? $this->underwriter->user_id : $this->underwriter->id ?? null
        );
    }
    //scope
     public function scopePending($query,$contractor_id = null){
        return $query->when(isset($contractor_id),function($q) use($contractor_id){
             $q->where('contractor_id',$contractor_id);
        })->where('status', 'Pending');
    }
    public function scopeCompleted($query,$contractor_id = null){
         return $query->when(isset($contractor_id),function($q) use($contractor_id){
             $q->where('contractor_id',$contractor_id);
         })
         ->whereHas('proposal',function($q){
            $q->where('is_invocation_notification',0);
         })
         ->where('nbi_status','Approved')
         ->where('status', 'Completed')
         ->where('decision_status','Approved')
         ->where('is_current',0)
         ->where('is_bond_managment_action_taken',0)
         ->whereDate('bond_end_date','>=',now());
    }
    public function scopeRoleBasedScope($query,$user_role,$user_id){

        return $query->when(isset($user_role) && isset($user_id),function()use($query,$user_role,$user_id){
            
           switch ($user_role) {
            case 'commercial-underwriter':
            case 'risk-underwriter':    
                $query->where('underwriter_id',$user_id)
                ->where('underwriter_type','Underwriter');
                break;
           }
        
        });
    }

    public function markAsRead(){
        return $this->morphOne(MarkAsRead::class,'markable');
    }

}
