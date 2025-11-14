<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Proposal'=>Proposal::class,
    'Principle'=>Principle::class
]);

class BankingLimit extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;


    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","bankinglimitsable_type","bankinglimitsable_id","contractor_fetch_reference_id","banking_category_id","facility_type_id","sanctioned_amount","bank_name","latest_limit_utilized","unutilized_limit","commission_on_pg","commission_on_fg","margin_collateral","other_banking_details","is_amendment","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function getBankingLimitCategoryName()
    {
        return $this->hasOne(BankingLimitCategory::class, 'id', 'banking_category_id');
    }

    public function getFacilityTypeName()
    {
        return $this->hasOne(FacilityType::class, 'id', 'facility_type_id');
    }

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function bankinglimitsable(){
        return $this->morphTo();
    }
}
