<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Sentinel;

class Country extends MyModel
{

    use \Venturecraft\Revisionable\RevisionableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'countries';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */

    protected $fillable = [
        "id","name","phone_code","code","mid_level","is_active","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'State' => array('field' => 'country_id', 'model' => State::class),
        'InsuranceCompanies' => array('field' => 'country_id', 'model' => InsuranceCompanies::class),
        'UnderWriter' => array('field' => 'country_id', 'model' => UnderWriter::class),
        'Agent' => array('field' => 'country_id', 'model' => Agent::class),
        'Broker' => array('field' => 'country_id', 'model' => Broker::class),
        'Principle' => array('field' => 'country_id', 'model' => Principle::class),
        'Beneficiary' => array('field' => 'country_id', 'model' => Beneficiary::class),
        'Tender' => array('field' => 'country_id', 'model' => Tender::class),
        'Employee' => array('field' => 'country_id', 'model' => Employee::class),
        'RelationshipManager' => array('field' => 'country_id', 'model' => RelationshipManager::class),
    );

    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }

    protected static function boot()
    {
        parent::boot();
    }

    public function currency(){
        return $this->belongsTo(Currency::class,'id', 'country_id');
    }
}
