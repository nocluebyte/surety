<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BondPoliciesIssue extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'bond_policies_issue';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","reference_no","proposal_id","version","contractor_id","bond_number","bond_type","insured_name","insured_address","project_details","beneficiary_id","beneficiary_address","beneficiary_phone_no","bond_conditionality","bond_type_id","contract_value","contract_currency","bond_value","cash_margin","tender_id","tender_details_id","bond_period_start_date","bond_period_end_date","bond_period","rate","net_premium","gst","gst_amount","gross_premium","stamp_duty_charges","total_premium","intermediary_name","intermediary_code","phone_no","special_condition","premium_date","premium_amount","additional_premium","status","is_amendment","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function beneficiary(){
        return $this->belongsTo(Beneficiary::class,'beneficiary_id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class,'contract_currency');
    }

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function proposal(){
        return $this->hasOne(Proposal::class, 'id','proposal_id');
    }

    public function bondType(){
        return $this->hasOne(BondTypes::class, 'id', 'bond_type_id');
    }

     public function scopeRoleBasedScope($query,$user_role,$user_id){

        return $query->when(isset($user_role) && isset($user_id),function()use($query,$user_role,$user_id){
            
           switch ($user_role) {
            case 'contractor':
                $query->where('bond_policies_issue.contractor_id',$user_id);
                break;
            case 'beneficiary':
                $query->where('bond_policies_issue.beneficiary_id',$user_id);
                break;
           }
        
        });
    }
}
