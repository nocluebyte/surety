<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherContractorInformation extends Model
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'other_contractor_informations';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","name","slug","from","to","financial","non_financial","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
}
