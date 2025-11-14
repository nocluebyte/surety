<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Schema;

class GroupContractor extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'group_contractors';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","group_id","contractor_id","type","from_date","till_date","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array();

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id')->with('contractor');
    }

    public function contractor()
    {
        return $this->belongsTo(Principle::class, 'contractor_id', 'id')->with(['country']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
