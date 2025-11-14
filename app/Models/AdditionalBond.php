<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalBond extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'additional_bonds';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","name","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function bidBond()
    {
        return $this->belongsTo(BidBond::class, 'id','additional_bond_id');
    }
    public function performanceBond()
    {
        return $this->belongsTo(PerformanceBond::class,'id','additional_bond_id');
    }
    public function retentionBond()
    {
        return $this->belongsTo(RetentionBond::class,'id','additional_bond_id');
    }
    public function maintenanceBond()
    {
        return $this->belongsTo(MaintenanceBond::class, 'id','additional_bond_id');
    }
    public function advancePaymentBond()
    {
        return $this->belongsTo(AdvancePaymentBond::class,'id','additional_bond_id');
    }
    public function proposalAdditionalBond()
    {
        return $this->hasMany(ProposalAdditionalBonds::class,'additional_bond_id','id');
    }
}
