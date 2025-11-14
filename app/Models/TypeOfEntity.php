<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sentinel;

class TypeOfEntity extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'type_of_entities';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","name","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'Principle' => array('field' => 'entity_type_id', 'model' => Principle::class),
        'Proposal' => array('field' => 'contractor_entity_type_id', 'model' => Proposal::class),
    );
}
