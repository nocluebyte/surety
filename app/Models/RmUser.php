<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmUser extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'rm_users';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","rm_user_id","user_id","is_active","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
