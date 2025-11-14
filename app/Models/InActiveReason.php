<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Sentinel;
use Illuminate\Database\Eloquent\Relations\MorphMany;

Relation::MorphMap([
    'AdverseInformation'=>AdverseInformation::class,
    'Blacklist'=>Blacklist::class,
]);

class InActiveReason extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'inactive_reasons';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","type","inactivereasonsable_type","inactivereasonsable_id","reason","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }
}
