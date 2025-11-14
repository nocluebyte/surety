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
class BalanceSheet extends MyModel
{
    use HasFactory;
    protected $table = 'balance_sheets';
    protected $fillable = [
        "id","casesable_type","casesable_id","cases_action_plan_id","cases_id","contractor_id","cash","tdrs","quick","stock","other_ca","total_ca","fixed_assets","intangible","other_fa","total_fa","total_bs_a","std","tr_crs","other_cl","total_cl","long_term","provision","total_ltd","equity","retained","net_worth","total_bs_b","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function casesable(): MorphTo{
        return $this->morphTo();
    }
    public function caseActionPlan(){
        return $this->hasMany(CasesActionPlan::class,'cases_action_plan_id','id');
    }
}
