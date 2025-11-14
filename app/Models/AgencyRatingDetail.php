<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyRatingDetail extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","agencyratingdetailsable_type","agencyratingdetailsable_id","agency_id","rating_id","rating","remarks","rating_date","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function agencyratingdetailsable(){
        return $this->morphTo();
    }

    public function agencyName(){;
        return $this->hasOne(Agency::class, 'id','agency_id');
    }
}
