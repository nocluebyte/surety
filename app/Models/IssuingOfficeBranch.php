<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuingOfficeBranch extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'issuing_office_branches';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","branch_name","branch_code","address","country_id","state_id","city","gst_no","oo_cbo_bo_kbo","bank","bank_branch","account_no","ifsc","micr","mode","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];
}
