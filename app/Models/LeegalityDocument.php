<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeegalityDocument extends MyModel
{
    use HasFactory;
    protected $fillable = [
        "id","name","email","proposal_id","nbi_id","contractor_id","document_id","phone","sign_url","active","expiry_date","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
}
