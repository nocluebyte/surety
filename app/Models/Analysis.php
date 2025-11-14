<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Sentinel;

class Analysis extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'analysis';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $fillable = [
        "id","contractor_id","case_id","case_action_plan_id","description","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    protected static function boot()
    {
        parent::boot();
    }
    public function case_action_plan(){
        return $this->belongsTo(CasesActionPlan::class,'case_action_plan_id');
    }
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function cases()
    {
        return $this->hasOne(Cases::class,'id','cases_id');
    }
}
