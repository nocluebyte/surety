<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Blacklist extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'blacklists';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","contractor_id","source","reason","blacklist_date","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function contractor()
    {
        return $this->belongsTo(Principle::class, 'contractor_id');
    }

    public function create_by(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function inActiveReason(): MorphMany
    {
        return $this->morphMany(InActiveReason::class, 'inactivereasonsable')->with('createdBy');
    }
}
