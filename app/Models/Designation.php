<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sentinel;

class Designation extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'designations';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","name","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'Proposal' => array('field' => 'designation', 'model' => ManagementProfiles::class),
        'Principle' => array('field' => 'designation', 'model' => ManagementProfiles::class),
        'Employee' => array('field' => 'designation_id', 'model' => Employee::class),
    );
}
