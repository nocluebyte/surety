<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sentinel;

class BondTypes extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'bond_types';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","prefix","name","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'Tender' => array('field' => 'bond_type_id', 'model' => Tender::class),
        'Proposal' => array('field' => 'bond_type', 'model' => Proposal::class),
    );
}
