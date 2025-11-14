<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Schema;

class Group extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'groups';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","contractor_id","group_cap","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array();

    public function groupContractor()
    {
        return $this->hasMany(GroupContractor::class, 'group_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Principle::class,'contractor_id','id');
    }
    public function casesLimitStrategy(){
        return $this->belongsTo(CasesLimitStrategy::class,'contractor_id','contractor_id');
    }

    public function updatedBy()
    {
        if (Schema::hasColumn($this->getTable(), 'updated_by')) {
            return $this->belongsTo(User::class, 'updated_by', 'id');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
