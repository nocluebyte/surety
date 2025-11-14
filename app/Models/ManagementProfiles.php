<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Proposal'=>Proposal::class,
    'Principle'=>Principle::class
]);


class ManagementProfiles extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'management_profiles';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","managementprofilesable_type","managementprofilesable_id","contractor_fetch_reference_id","designation","name","qualifications","experience","is_amendment","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function getDesignationName()
    {
        return $this->hasOne(Designation::class, 'id', 'designation');
    }

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }
    public function managementprofilesable(){
        return $this->morphTo();
    }
}
