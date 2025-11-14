<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'agencies';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","agency_name","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'AgencyRating' => array('field' => 'agency_id', 'model' => AgencyRating::class),
        'Principle/Contractor' => array('field' => 'agency_id', 'model' => AgencyRatingDetail::class),
    );
}
