<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tender extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'tenders';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","first_name","middle_name","last_name","beneficiary_id","email","phone_no","address","pan_no","country_id","state_id","city","contract_value","period_of_contract","bond_value","bond_type_id","bond_start_date","bond_end_date","period_of_bond","tender_description","tender_id","tender_header","location","project_type","tender_reference_no","rfp_date","project_description","type_of_contracting","project_details","pd_beneficiary","pd_project_name","pd_project_description","pd_project_value","pd_type_of_project","pd_project_start_date","pd_project_end_date","pd_period_of_project","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'Proposal' => array('field' => 'tender_details_id', 'model' => Proposal::class),
    );

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    // protected function panNo(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn (string $value) => strtoupper($value),
    //     );
    // }

    // public function country()
    // {
    //     return $this->belongsTo(Country::class, 'country_id');
    // }

    // public function state()
    // {
    //     return $this->belongsTo(State::class, 'state_id');
    // }

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }

    public function projectDetailsBeneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'pd_beneficiary');
    }

    public function bondType()
    {
        return $this->belongsTo(BondTypes::class, 'bond_type_id');
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type');
    }

     public function scopeRoleBasedScope($query,$user_role,$user_id){

        return $query->when(isset($user_role) && isset($user_id),function()use($query,$user_role,$user_id){
            
           switch ($user_role) {
            case 'beneficiary':
                $query->where('tenders.beneficiary_id',$user_id);
                break;
           }
        
        });
    }

    public function bondPoliciesIssue()
    {
        return $this->hasMany(BondPoliciesIssue::class, 'tender_details_id', 'id');
    }
}
