<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CasesDecision extends MyModel
{
    use HasFactory;
    use SoftDeletes;

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'cases_decisions';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","proposal_id","cases_id","contractor_id","project_acceptable","project_acceptable_remark","bond_type_id","bond_value","bond_start_date","bond_end_date","decision_status","nbi_status","remark","is_amendment","is_bond_managment_action_taken","bond_managment_action_type","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function bondType(){
        return $this->belongsTo(BondTypes::class,'bond_type_id');
    }

    public function proposal(){
        return $this->belongsTo(Proposal::class,'proposal_id');
    }

    public function cases(){
        return $this->belongsTo(Cases::class,'cases_id');
    }

      public function scopeCompleted($query,$contractor_id = null){
         return $query->when(isset($contractor_id),function($q) use($contractor_id){
             $q->where('contractor_id',$contractor_id);
         })
        //  ->where('status', 'Completed')
         ->whereNotNull('decision_status')
         ->where('is_amendment',0)
         ->where('is_bond_managment_action_taken',0);
    }
    
}
