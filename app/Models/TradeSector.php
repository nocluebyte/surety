<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sentinel;

class TradeSector extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'trade_sectors';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","name","mid_level","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'Beneficiary' => array('field' => 'trade_sector_id', 'model' => ProposalBeneficiaryTradeSector::class),
        'Proposal' => array('field' => 'trade_sector_id', 'model' => ProposalBeneficiaryTradeSector::class),
        'Principle/Contractor' => array('field' => 'trade_sector_id', 'model' => TradeSectorItem::class),
    );
}
