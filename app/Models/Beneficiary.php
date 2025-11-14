<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sentinel;
use Illuminate\Database\Eloquent\Relations\morphOne;
use Illuminate\Database\Eloquent\Relations\morphMany;

class Beneficiary extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'beneficiaries';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","company_name","company_code","reference_code","registration_no","beneficiary_type","ministry_type_id","establishment_type_id","bond_wording","address","city","pincode","country_id","state_id","pan_no","gst_no","website","user_id","is_active","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'User' => array('field' => 'id', 'model' => User::class),
        'Tender' => array('field' => 'id', 'model' => Tender::class),
    );

    public  function  user(): BelongsTo{
        return $this->belongsTo(User::class,'user_id','id');
    }

    // protected function panNo(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn (string $value) => strtoupper($value),
    //     );
    // }

    public function dMS(): morphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }
    public function cases(): morphMany
    {
        return $this->morphMany(Cases::class, 'casesable');
    }

    public function scopePending(): morphMany
    {
        return $this->morphMany(Cases::class, 'casesable')->whereIn('status',['Pending','Transfer']);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    // public function typeOfBeneficiaryEntity()
    // {
    //     return $this->belongsTo(TypeOfEntity::class, 'type_of_beneficiary_entity');
    // }

    public function establishmentTypeId()
    {
        return $this->belongsTo(EstablishmentType::class, 'establishment_type_id');
    }
    public function proposalBeneficiaryTradeSector(){
        return $this->morphMany(ProposalBeneficiaryTradeSector::class,'proposalbeneficiarytradesectorsable')->with(['tradeSector']);
    }

    public function underwriterCasesLog(){
        return $this->hasMany(UnderwriterCasesLog::class, 'underwriter_id');
    }

    public function ministryType()
    {
        return $this->belongsTo(MinistryType::class, 'ministry_type_id');
    }
    public function markAsRead(){
        return $this->morphOne(MarkAsRead::class,'markable');
    }
}
