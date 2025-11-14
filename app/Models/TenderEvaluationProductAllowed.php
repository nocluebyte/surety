<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TenderEvaluationProductAllowed extends MyModel
{
    use HasFactory;
    protected $table = 'tender_evaluation_product_alloweds';
    protected $fillable = [
        "id","tender_evaluation_id","proposal_id","cases_id","project_type_id","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
    public function create_by(){;
        return $this->belongsTo(User::class,'created_by');
    }
}
