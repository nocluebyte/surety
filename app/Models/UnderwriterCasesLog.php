<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
Relation::MorphMap([
    'Beneficiary' => Beneficiary::class,
    'Principle'=>Principle::class,
]);
class UnderwriterCasesLog extends MyModel
{
    use HasFactory;
    protected $table = 'underwriter_cases_logs';
    protected $fillable = [
        "id","casesable_type","casesable_id","cases_action_plan_id","cases_id","underwriter_id","underwriter_type","notes","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function casesable(): MorphTo{
        return $this->morphTo();
    }
    public function caseActionPlan(){
        return $this->hasMany(CasesActionPlan::class,'cases_action_plan_id','id');
    }
    // public function UnderWriter(){
    //     return $this->belongsTo(UnderWriter::class,'underwriter_id')->with('user');
    // }

    public function underwriter()
    {
        return $this->morphTo();
    }

    public function create_by(){;
        return $this->belongsTo(User::class,'created_by');
    }
     public function underwriterUserName() : Attribute   {
        return Attribute::make(
            get: function () {
            if ($this->underwriter_type === 'User' && $this->underwriter) {
                return $this->underwriter->full_name;
            }

            if ($this->underwriter_type === 'Underwriter' && $this->underwriter?->user) {
                return $this->underwriter->user->full_name;
            }

            return null;
        } 
        );
    }
}
