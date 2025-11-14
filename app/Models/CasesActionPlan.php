<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Sentinel;

class CasesActionPlan extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'cases_action_plans';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $fillable = [
        "id","cases_id","contractor_id","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    protected static function boot()
    {
        parent::boot();
    }
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function cases()
    {
        return $this->hasOne(Cases::class,'id','cases_id');
    }
    public function profitLoss()
    {
        return $this->hasOne(ProfitLoss::class,'contractor_id','contractor_id')->latestOfMany();
    }
    public function balanceSheet()
    {
        return $this->hasOne(BalanceSheet::class,'contractor_id','contractor_id')->latestOfMany();
    }
    public function ratios()
    {
        return $this->hasOne(Ratio::class,'contractor_id','contractor_id')->latestOfMany();
    }
    public function casesLimitStrategySaveData()
    {
        return $this->hasOne(CasesLimitStrategy::class,'contractor_id','contractor_id')->with('user')->where('status','Save')->where(['status'=>'Save','is_current'=>'0']);
    }
    public function casesLimitStrategy()
    {
        return $this->hasMany(CasesLimitStrategy::class,'contractor_id','contractor_id')->where('is_current','1')->with('user');
    }
    public function casesLimitStrategyTransferData()
    {
        return $this->hasOne(CasesLimitStrategy::class,'cases_action_plan_id')->orderByDesc('created_at')->limit(1);
    }
    public function casesBondLimitStrategySaveData()
    {
        return $this->hasMany(CasesBondLimitStrategy::class,'contractor_id','contractor_id')->with('user')->where(['status'=>'Save','is_current'=>'0']);
    }
    public function casesBondLimitStrategy()
    {
        return $this->hasMany(CasesBondLimitStrategy::class,'contractor_id','contractor_id')->where('is_current','1')->with('user','bondType');
    }

    public function utilizedCasesLimitStrategy(){
        return $this->hasMany(UtilizedLimitStrategys::class,'contractor_id','contractor_id')->where('strategyable_type','CasesLimitStrategy')->where(['is_bond_managment_action_taken'=>0,'is_last_of_approved'=>0])
        ->where('bond_end_date','>=',now());
    }

    public function utilizedCasesBondLimitStrategy($bond_type_id=null,$withsum=null){
        return $this->hasMany(UtilizedLimitStrategys::class,'contractor_id','contractor_id')
         ->whereHas('proposal',function($q){
            $q->where('is_invocation_notification',0);
         })
         ->when($bond_type_id,function($q) use($bond_type_id){
            $q->where('bond_type_id',$bond_type_id);
         })
        ->where('nbi_status','Approved')
        ->where('strategyable_type','CasesBondLimitStrategy')
        ->where(['is_bond_managment_action_taken'=>0,'is_last_of_approved'=>0])
        ->where('bond_end_date','>=',now())
        ->when($withsum==='sum',function($q) {
            return $q->sum('value');
         });
    }
}
