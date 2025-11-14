<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DmsComment extends MyModel
{
    use HasFactory;

    protected $fillable = [
        "id","dms_id","comment","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }

}
