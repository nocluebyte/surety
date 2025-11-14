<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BondProgress extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'bond_progresses';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","proposal_id","version","bond_type","progress_date","progress_remarks","physical_completion_remarks","dispute_initiated","dispute_initiated_remarks","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function create_by(){;
        return $this->belongsTo(User::class,'created_by');
    }

    public function bondType()
    {
        return $this->belongsTo(BondTypes::class, 'bond_type');
    }
}
