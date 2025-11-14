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
class ProfitLoss extends MyModel
{
    use HasFactory;
    protected $table = 'profit_loss';
    protected $fillable = [
        "id","casesable_type","casesable_id","cases_action_plan_id","cases_id","contractor_id","sales","exp","ebidta","int","dep","net_other","pbt","tax","pat","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function casesable(): MorphTo{
        return $this->morphTo();
    }
    public function caseActionPlan(){
        return $this->hasMany(CasesActionPlan::class,'cases_action_plan_id','id');
    }
}
