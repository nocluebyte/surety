<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Endorsement extends MyModel
{
    use HasFactory;
    protected $fillable = [
        "id","endorsement_number","proposal_id","cases_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function dMS(): MorphOne
    {
        return $this->MorphOne(DMS::class, 'dmsable');
    }
}
