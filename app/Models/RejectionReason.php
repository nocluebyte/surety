<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectionReason extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'rejection_reasons';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","reason","description","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'Proposal' => array('field' => 'rejection_reason_id', 'model' => Proposal::class),
    );
}
