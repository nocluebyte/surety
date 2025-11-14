<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Proposal extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'proposals';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","version","contract_type","proposal_parent_id","contractor_id","pan_no","register_address","parent_group","date_of_incorporation","registration_no","contractor_company_name","contractor_website","contractor_country_id","contractor_state_id","contractor_city","contractor_pincode","contractor_gst_no","contractor_pan_no","contractor_email","contractor_mobile","contractor_same_as_above","contractor_bond_address","contractor_bond_country_id","contractor_bond_state_id","contractor_bond_city","contractor_bond_pincode","contractor_bond_gst_no","contractor_inception_date","contractor_entity_type_id","contractor_staff_strength","principle_type_id","are_you_blacklisted","is_jv","tender_details_id","tender_beneficiary_id","beneficiary_id","beneficiary_address","beneficiary_type","tender_id","tender_header","contract_value","period_of_contract","location","project_type","tender_bond_value","bond_type_id","rfp_date","type_of_contracting","tender_description","tender_contract_value","project_description","project_details","pd_beneficiary","pd_project_name","pd_project_description","pd_project_value","pd_type_of_project","pd_project_start_date","pd_project_end_date","pd_period_of_project","beneficiary_registration_no","beneficiary_company_name","beneficiary_email","beneficiary_phone_no","beneficiary_website","beneficiary_country_id","beneficiary_state_id","beneficiary_city","beneficiary_pincode","beneficiary_gst_no","beneficiary_pan_no","establishment_type_id","ministry_type_id","beneficiary_same_as_above","beneficiary_bond_address","beneficiary_bond_country_id","beneficiary_bond_state_id","beneficiary_bond_city","beneficiary_bond_pincode","beneficiary_bond_gst_no","beneficiary_bond_wording","bond_value","bond_type","project_value","bond_triggers","main_obligation","bond_period_description","bond_required","bond_wording","bond_collateral","distribution","agency_id","agency_rating_id","rating_remarks","bond_start_date","bond_end_date","bond_period","bond_period_year","bond_period_month","bond_period_days","bid_requirement","relevant_conditions","is_bank_guarantee_provided","circumstance_short_notes","is_action_against_proposer","action_details","contractor_failed_project_details","completed_rectification_details","performance_security_details","relevant_other_information","status","nbi_status","rejection_reason_id","is_amendment","is_nbi","cases_id","leegality_document_id","is_checklist_approved","is_issue","is_invocation_notification","is_bond_foreclosure","is_bond_cancellation","is_claim_converted","is_autosave","tender_evaluation","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];
    protected $append = ['full_name','proposal_full_name'];
    protected $dependency = array(
        'Nbi' => array('field' => 'proposal_id', 'model' => Nbi::class),
        'Bid Bond' => array('field' => 'proposal_id', 'model' => BidBond::class),
        'Performance Bond' => array('field' => 'proposal_id', 'model' => PerformanceBond::class),
    );

    protected static function boot()
    {
        parent::boot();
    }

    public function getProposalFullNameAttribute()
    {
        if(!empty($this->code) && !empty($this->full_name)) {
            $proposal_name = $this->code . " - " . $this->full_name;
        } else {
            $proposal_name = '';
        }
        return $proposal_name;
    }

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function cases(): morphMany
    {
        return $this->morphMany(Cases::class, 'casesable');
    }
    
    public function bankingLimits(): MorphMany
    {
        return $this->morphMany(BankingLimit::class,'bankinglimitsable');
    }

    public function orderBookAndFutureProjects(): MorphMany
    {
        return $this->morphMany(OrderBookAndFutureProjects::class,'orderbookandfutureprojectsable');
    }

    public function projectTrackRecords(): MorphMany
    {
        return $this->morphMany(ProjectTrackRecords::class,'projecttrackrecordsable');
    }

    public function managementProfiles(): MorphMany
    {
        return $this->morphMany(ManagementProfiles::class,'managementprofilesable');
    }
    public function additionalBonds()
    {
        return $this->hasMany(ProposalAdditionalBonds::class);
    }

    public function getDesignationName()
    {
        return $this->hasOne(Designation::class, 'id', 'chairman_designation');
    }

    public function getBondTypeName() // Tender Bond Type
    {
        return $this->hasOne(BondTypes::class, 'id', 'bond_type_id');
    }
    public function createdBy(){
        return $this->hasOne(User::class,'created_by');
    }
    public function sourceName()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function beneficiary(){
        return $this->belongsTo(Beneficiary::class,'beneficiary_id');
    }
    public function contractor(){
        return $this->belongsTo(Principle::class, 'contractor_id')->with('country', 'user');
    }
    public function tenderEvaluation(){
        return $this->hasMany(TenderEvaluation::class,'proposal_id');
    }
    public function tender(){;
        return $this->hasOne(Tender::class, 'id','tender_details_id');
    }
    public function fullName()
    {
        $full_name = (!is_null($this->first_name) && !is_null($this->last_name))  ? $this->first_name . " " . $this->last_name : $this->first_name;
        return $full_name;
    }
    public function nbi(){
        return $this->hasMany(Nbi::class,'proposal_id');
    }

    public function bondType()
    {
        return $this->belongsTo(BondTypes::class, 'type_of_bond');
    }

    public function proposalContractors()
    {
        return $this->hasMany(ProposalContractor::class)->with(['mainContractor', 'contractor.contractorAdverseInformation', 'contractor.contractorBlacklistInformation']);
    }

    public function tradeSector(){
        return $this->morphMany(TradeSectorItem::class,'tradesectoritemsable')->with(['tradeSector']);
    }

    public function contractorItem()
    {
        return $this->morphMany(ContractorItem::class, 'contractoritemsable')->with('contractor');
    }

    public function contactDetail(){
        return $this->morphMany(ContactDetail::class,'contactdetailsable');
    }

    public function proposalBeneficiaryTradeSector(){
        return $this->morphMany(ProposalBeneficiaryTradeSector::class,'proposalbeneficiarytradesectorsable')->with(['tradeSector']);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'contractor_country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'contractor_state_id');
    }

    public function benificiaryCountry()
    {
        return $this->belongsTo(Country::class, 'beneficiary_country_id');
    }

    public function benificiaryState()
    {
        return $this->belongsTo(State::class, 'beneficiary_state_id');
    }

    public function agency(){;
        return $this->hasOne(Agency::class, 'id','agency_id');
    }

    public function agencyRating(){;
        return $this->hasOne(AgencyRating::class, 'id','agency_rating_id');
    }

    public function principleType(){;
        return $this->hasOne(PrincipleType::class, 'id','principle_type_id');
    }

    public function projectType(){;
        return $this->hasOne(ProjectType::class, 'id','project_type');
    }

    public function projectDetails(){;
        return $this->hasOne(ProjectDetail::class, 'id','project_details');
    }

    public function projectDetailsBeneficiary(){
        return $this->belongsTo(Beneficiary::class,'pd_beneficiary');
    }

    public function projectDetailsProjectType(){;
        return $this->hasOne(ProjectType::class, 'id','pd_type_of_project');
    }

    public function establishmentType(){;
        return $this->hasOne(EstablishmentType::class, 'id','establishment_type_id');
    }

    public function ministryType(){;
        return $this->hasOne(MinistryType::class, 'id','ministry_type_id');
    }

    public function getBondType()  // Bond Details Bond Type
    {
        return $this->hasOne(BondTypes::class, 'id', 'bond_type');
    }

    public function Endorsement(){
        return $this->hasOne(Endorsement::class,'proposal_id');
    }

    public function agencyRatingDetails(): MorphMany
    {
        return $this->morphMany(AgencyRatingDetail::class,'agencyratingdetailsable');
    }
    public function invocationNotification()
    {
        return $this->belongsTo(InvocationNotification::class, 'id','proposal_id');
    }

    public function additionalContractorCountry()
    {
        return $this->belongsTo(Country::class, 'contractor_bond_country_id');
    }

    public function additionalContractorState()
    {
        return $this->belongsTo(State::class, 'contractor_bond_state_id');
    }

    public function additionalBeneficiaryCountry()
    {
        return $this->belongsTo(Country::class, 'beneficiary_bond_country_id');
    }

    public function additionalBeneficiaryState()
    {
        return $this->belongsTo(State::class, 'beneficiary_bond_state_id');
    }
    public function adverseInformation()
    {
        return $this->hasMany(AdverseInformation::class, 'contractor_id', 'contractor_id');
    }
    public function parentProposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_parent_id')->with('proposalChecklist');
    }
    public function proposalChecklist()
    {
        return $this->hasOne(BondPoliciesIssueChecklist::class, 'proposal_id');
    }

    public function rejectionReason(){
        return $this->belongsTo(RejectionReason::class,'rejection_reason_id');
    }    
    public function typeOfEntity(){
        return $this->belongsTo(TypeOfEntity::class,'contractor_entity_type_id');
    }
     public function proposalIssue()
    {
        return $this->hasOne(BondPoliciesIssue::class, 'proposal_id');
    }

    public function blacklistInformation()
    {
        return $this->hasMany(Blacklist::class, 'contractor_id', 'contractor_id');
    }

    //accessor or mutetor

    public function IndemnityLetterThroughLeegality():Attribute{
        return  Attribute::make(
            get:fn() => isset($this->leegality_document_id) ? true : false
        ); 
    }

    //scope
    public function scopeRoleBasedScope($query,$user_role,$user_id){

        return $query->when(isset($user_role) && isset($user_id),function()use($query,$user_role,$user_id){
            
           switch ($user_role) {
            case 'contractor':
                $query->where('proposals.contractor_id',$user_id);
                break;
            case 'beneficiary':
                $query->where('proposals.beneficiary_id',$user_id);
                break;
           }
        
        });
    }
      public function markAsRead(){
        return $this->morphOne(MarkAsRead::class,'markable');
      }
    
}
