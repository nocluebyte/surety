<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Proposal'=>Proposal::class,
    'Beneficiary'=>Beneficiary::class
]);

class ProposalBeneficiaryTradeSector extends Model
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'proposal_beneficiary_trade_sectors';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","contractor_fetch_reference_id","proposalbeneficiarytradesectorsable_type","proposalbeneficiarytradesectorsable_id","trade_sector_id","from","till","is_main","is_amendment","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function tradeSector(){
        return $this->belongsTo(TradeSector::class,'trade_sector_id');
    }
}
