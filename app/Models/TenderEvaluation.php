<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TenderEvaluation extends MyModel
{
    use HasFactory;
    protected $table = 'tender_evaluations';
    protected $fillable = [
        "id","proposal_id","cases_id","contractor_id","rating_score","tender_id","project_description","beneficiary_id","project_value","bond_value","bond_start_date","bond_end_date","bond_period","overall_capacity","individual_capacity","old_contract_running_contract","replacement_bg_for_existing_contract","experience_of_similar_contract_size","complexity_of_project_allowed","type_of_projects_allowed","type_of_bond_allowed","tenure_id","strategic_nature_of_the_project","user_id","other_work_type","attachment","remarks","year_id","status","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
    public function create_by(){;
        return $this->belongsTo(User::class,'created_by');
    }
    public function contractor(){;
        return $this->hasOne(Principle::class, 'id','contractor_id');
    }
    public function beneficiary(){;
        return $this->hasOne(Beneficiary::class, 'id','beneficiary_id');
    }
    public function proposal(){;
        return $this->hasOne(Proposal::class, 'id','proposal_id');
    }
    public function productAllowed(){
        return $this->hasMany(TenderEvaluationProductAllowed::class,'tender_evaluation_id');
    }
    public function work_type(){
        return $this->hasMany(TenderEvaluationWorkType::class,'tender_evaluation_id');
    }
    public function location(){
        return $this->hasMany(TenderEvaluationLocation::class,'tender_evaluation_id');
    }
}
