<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasesLimitStrategy extends MyModel
{
    use HasFactory;
    protected $table = 'cases_limit_strategys';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $fillable = [
        "id","contractor_id","casesable_type","casesable_id","cases_action_plan_id","cases_id","proposed_individual_cap","proposed_overall_cap","proposed_valid_till","proposed_group_cap","is_current","status","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
    public function casesActionPlan()
    {
        return $this->belongsTo(CasesActionPlan::class, 'cases_action_plan_id');
    }
    public function cases()
    {
        return $this->belongsTo(Cases::class, 'cases_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function utilizedlimit(){
        return $this->morphMany(UtilizedLimitStrategys::class,'strategyable');
    }

    public function utilizedlimitTopOfApproved($bond_type_id=null){
        return $this->hasMany(UtilizedLimitStrategys::class,'contractor_id','contractor_id')
        ->when($bond_type_id,function($q)use($bond_type_id){
            $q->where('bond_type_id',$bond_type_id);
        })
        ->where('is_last_of_approved',0)
        ->where('decision_status','Approved')
        ->where('is_bond_managment_action_taken',0)
        ->whereDate('bond_end_date','>=',now());
    }
}
