<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReInsuranceGrouping extends MyModel
{
    use HasFactory;
    protected $fillable = [
        "id","name","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

}
