<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Sentinel;

class ClaimExaminer extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'claim_examiners';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","address","city","post_code","country_id","state_id","user_id","max_approved_limit","is_active","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public  function  user(): BelongsTo{
        return $this->belongsTo(User::class,'user_id','id');
    }

    protected $dependency = array(
        'User' => array('field' => 'id', 'model' => User::class),
    );

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
