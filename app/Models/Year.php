<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends MyModel
{
    use \Venturecraft\Revisionable\RevisionableTrait;


    protected $table = 'years';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    use HasFactory;

    protected $fillable = [
        "id","yearname","is_default","is_displayed","from_date","to_date","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
}
