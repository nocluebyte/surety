<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Proposal'=>Proposal::class,
    'Principle'=>Principle::class
]);


class OrderBookAndFutureProjects extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'order_book_and_future_projects';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","orderbookandfutureprojectsable_type","orderbookandfutureprojectsable_id","contractor_fetch_reference_id","project_name","project_cost","project_description","project_start_date","project_end_date","project_tenor","bank_guarantees_details","project_share","guarantee_amount","current_status","is_amendment","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function getProjectTypeName()
    {
        return $this->hasOne(ProjectType::class, 'id', 'type_of_project');
    }

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function orderbookandfutureprojectsable(){
        return $this->morphTo();
    }
}
