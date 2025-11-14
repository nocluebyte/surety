<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sentinel;

class Agent extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'agents';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","address","city","country_id","state_id","pan_no","user_id","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public  function  user(): BelongsTo{
        return $this->belongsTo(User::class,'user_id','id');
    }

    // protected function panNo(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn (string $value) => strtoupper($value),
    //     );
    // }
    protected $dependency = array(
        'User' => array('field' => 'id', 'model' => User::class),
    );

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function intermediaryDetails(){
        return $this->morphMany(IntermediaryDetail::class,'intermediaryable');
    }
    public function intermediaryDetailsFirst(){
        return $this->morphOne(IntermediaryDetail::class,'intermediaryable');
    }
}
