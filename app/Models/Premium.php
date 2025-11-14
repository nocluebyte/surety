<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::MorphMap([
    'BidBond'=>BidBond::class,
]);

class Premium extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'premium_collections';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","proposal_id","bond_type","tender_id","beneficiary_id","bond_value","payment_received","payment_received_date","remarks","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function premiumContractors()
    {
        return $this->hasMany(PremiumContractors::class, 'premium_id');
    }
    public function bondType()
    {
        return $this->hasOne(BondTypes::class, 'id', 'bond_type');
    }
}
