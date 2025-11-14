<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sentinel;

class ProjectType extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'project_types';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","name","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'Proposal' => array('field' => 'pd_type_of_project', 'model' => Proposal::class),
        'Project Details' => array('field' => 'type_of_project', 'model' => ProjectDetail::class),
    );
}
