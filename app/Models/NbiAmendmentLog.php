<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NbiAmendmentLog extends MyModel
{
    use HasFactory;
    protected $table = 'nbi_amendment_logs';
    protected $fillable = [
        "id","nbi_id","bond_id","parent_nbi_id","field_name","old_value","new_value","nbi_type","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];
    public function create_by(){;
        return $this->belongsTo(User::class,'created_by');
    }
}
