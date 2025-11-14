<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelationshipManager extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'relationship_managers';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","address","country_id","state_id","city","post_code","user_id","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    public  function  user(): BelongsTo{
        return $this->belongsTo(User::class,'user_id','id');
    }

    protected $dependency = array(
        'User' => array('field' => 'id', 'model' => User::class),
    );
}
