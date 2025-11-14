<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProposalAdditionalBonds extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'proposal_additional_bonds';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","proposal_id","additional_bond_id","additional_bond_issued_date","additional_bond_start_date","additional_bond_end_date","additional_bond_period","additional_bond_period_year","additional_bond_period_month","additional_bond_period_days","bond_value","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function getAdditionalBondName()
    {
        return $this->hasOne(AdditionalBond::class, 'id', 'additional_bond_id');
    }
   
}
