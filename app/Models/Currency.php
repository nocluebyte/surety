<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Sentinel;

class Currency extends MyModel
{

    use \Venturecraft\Revisionable\RevisionableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'currencys';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $fillable = [
        "id","country_id","short_name","symbol","is_active","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */

    protected $dependency = array(
        'Cases Action Plans' => array('field' => 'currency_id', 'model' => CasesActionPlan::class),
    );

    protected static function boot()
    {
        parent::boot();
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id', 'id');
    }
}
