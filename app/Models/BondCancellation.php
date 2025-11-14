<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BondCancellation extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'bond_cancellations';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","proposal_id","bond_number","contractor_id","beneficiary_id","project_details_id","tender_id","bond_type_id","bond_start_date","bond_end_date","bond_conditionality","premium_amount","cancellation_date","bond_cancellation_type","pre_project_remarks","mid_project_remarks","any_other_type_remarks","remarks","is_refund","refund_remarks","is_original_bond_received","is_confirming_foreclosure","is_any_other_proof","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function proposal(){
        return $this->hasOne(Proposal::class, 'id','proposal_id');
    }
}
