<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvocationNotificationAnalysis extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'invocation_notification_analyses';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $fillable = [
        "id","invocation_notification_id","remark","year_id","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];
}
