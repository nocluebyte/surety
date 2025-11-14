<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class NbiLog extends MyModel
{
    use HasFactory;
    protected $table = 'nbi_logs';
    protected $fillable = [
        "id","proposal_id","bond_id","nbi_id","current_status","new_status","remarks","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
    public function create_by(){;
        return $this->belongsTo(User::class,'created_by');
    }
}
