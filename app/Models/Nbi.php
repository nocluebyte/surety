<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Nbi extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $table = 'nbis';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $fillable = [
        "id","policy_no","nbi_type","proposal_id","version","bond_id","contractor_id","insured_address","endorsement_number","project_details","beneficiary_id","beneficiary_address","beneficiary_contact_person_name","beneficiary_contact_person_phone_no","bond_type","bond_number","bond_conditionality","contract_value","contract_currency_id","bond_value","cash_margin_if_applicable","cash_margin_amount","tender_id_loa_ref_no","bond_period_start_date","bond_period_end_date","bond_period_days","initial_fd_validity","rate","net_premium","hsn_code_id","cgst","cgst_amount","sgst","sgst_amount","igst","gst_amount","gross_premium","stamp_duty_charges","total_premium_including_stamp_duty","intermediary_name","intermediary_code_and_contact_details","re_insurance_grouping_id","trade_sector_id","bond_wording","status","is_amendment","premium_effected","issuing_office_branch_id","rejection_reason_id","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
    public function contractor(){
        return $this->hasOne(Principle::class,'id','contractor_id');
    }
    public function beneficiary(){
        return $this->belongsTo(Beneficiary::class,'beneficiary_id');
    }
    public function bondType(){
        return $this->belongsTo(BondTypes::class,'bond_type');
    }
    public function currency(){
        return $this->belongsTo(Currency::class,'contract_currency_id');
    }
    public function hsn_code(){
        return $this->belongsTo(HsnCode::class,'hsn_code_id');
    }
    public function reInsuranceGrouping(){
        return $this->belongsTo(ReInsuranceGrouping::class,'re_insurance_grouping_id');
    }
    public function issuingOfficeBranch(){
        return $this->belongsTo(IssuingOfficeBranch::class,'issuing_office_branch_id');
    }

    public function bidbond()
    {
        return $this->belongsTo(BidBond::class, 'bond_id');
    }

    public function performanceBond()
    {
        return $this->belongsTo(PerformanceBond::class, 'bond_id');
    }

    public function advancePaymentBond()
    {
        return $this->belongsTo(AdvancePaymentBond::class, 'bond_id');
    }

    public function retentionBond()
    {
        return $this->belongsTo(RetentionBond::class, 'bond_id');
    }

    public function maintenanceBond()
    {
        return $this->belongsTo(MaintenanceBond::class, 'bond_id');
    }

    public function tradeSector(){
        return $this->belongsTo(TradeSector::class,'trade_sector_id');
    }
}
