<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Broker'=>Broker::class,
    'Agent'=>Agent::class
]);

class IntermediaryDetail extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","intermediaryable_type","intermediaryable_id","code","name","email","mobile","address","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function intermediaryable(){
        return $this->morphTo(IntermediaryDetail::class,'intermediaryable');
    }
}
