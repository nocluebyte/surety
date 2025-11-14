<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\morphMany;
use Illuminate\Database\Eloquent\Model;

class InvocationClaims extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'invocation_claims';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","invocation_id","bond_type","proposal_id","version","bond_detail","conditional","bond_wording","invocation_notice_date","invocation_claim_date","claim_form","invocation_notice","contract_copy","correspondence_details","arbitration","dispute","bank_name","account_number","bank_address","account_type","micr","ifsc_code","claimed_amount","claimed_disallowed","total_claim_approved","remark","status","is_amendment","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function dmsamend(): MorphTo{
        return $this->morphTo();
    }
    public function dMS(): MorphMany{
        return $this->morphMany(DMS::class,'dmsable');
    }
    public function bondType(){
        return $this->belongsTo(BondTypes::class,'bond_type');
    }
    public function proposal(){
        return $this->belongsTo(Proposal::class,'proposal_id','id');
    }
}
