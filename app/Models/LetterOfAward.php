<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class LetterOfAward extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'letter_of_awards';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","contractor_id","beneficiary_id","project_details_id","tender_id","ref_no_loa","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function getContractor()
    {
        return $this->hasOne(Principle::class, 'id', 'contractor_id');
    }

    public function getBeneficiary()
    {
        return $this->hasOne(Beneficiary::class, 'id', 'beneficiary_id');
    }

    public function getProjectDetails()
    {
        return $this->hasOne(ProjectDetail::class, 'id', 'project_details_id');
    }

    public function getTender()
    {
        return $this->hasOne(Tender::class, 'id', 'tender_id');
    }
}
