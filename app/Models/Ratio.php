<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
Relation::MorphMap([
    'Beneficiary' => Beneficiary::class,
    'Principle'=>Principle::class,
]);
class Ratio extends MyModel
{
    use HasFactory;
    protected $table = 'ratios';
    protected $fillable = [
        "id","casesable_type","casesable_id","cases_action_plan_id","cases_id","contractor_id","gp","ebidta","bt","icr","drs","crs","stock_turnover","credity_cycle","term_gearing","total_gearing","solvability","c_ratio","quick_ratio","working_capital","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function casesable(): MorphTo{
        return $this->morphTo();
    }
    public function caseActionPlan(){
        return $this->hasMany(CasesActionPlan::class,'cases_action_plan_id','id');
    }
}
