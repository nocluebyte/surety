<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::MorphMap([
    'CasesLimitStrategy'=>CasesLimitStrategy::class,
    'CasesBondLimitStrategy'=>CasesBondLimitStrategy::class
]);

class UtilizedLimitStrategys extends MyModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "id","strategyable_type","strategyable_id","contractor_id","proposal_code","proposal_id","cases_action_plan_id","cases_id","bond_type_id","cases_decisions_id","value","decision_status","nbi_status","bond_end_date","is_last_of_approved","is_amendment","is_current","is_bond_managment_action_taken","bond_managment_action_type","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function proposal(){
        return $this->belongsTo(Proposal::class,'proposal_id','id');
    }
    public function strategyable(){
        return $this->morphTo();
    }
}
