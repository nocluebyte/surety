<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalContractor extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'proposal_contractors';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","proposal_id","proposal_contractor_type","proposal_contractor_id","pan_no","overall_cap","spare_capacity","share_holding","jv_spv_exposure","assign_exposure","consumed","remaining_cap","is_amendment","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function contractor()
    {
        return $this->hasOne(Principle::class, 'id', 'proposal_contractor_id')->with('contractorItem');
    }

    public function mainContractor()
    {
        return $this->hasOne(ContractorItem::class, 'contractor_id', 'proposal_contractor_id');
    }
    public function adverseInformation()
    {
        return $this->hasOne(AdverseInformation::class, 'contractor_id', 'proposal_contractor_id');
    }
}
