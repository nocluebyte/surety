<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\morphMany; 
use Illuminate\Database\Eloquent\Model;
use Sentinel;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Proposal'=>Proposal::class,
    'Principle'=>Principle::class
]);

class ContractorItem extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'contractor_items';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","contractoritemsable_type","contractoritemsable_id","contractor_id","pan_no","share_holding","is_amendment","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function principle()
    {
        return $this->belongsTo(Principle::class,'principle_id');
    }
    public function contractor()
    {
        return $this->belongsTo(Principle::class,'contractor_id')->with('contractorAdverseInformation', 'contractorBlacklistInformation');
    }

}
