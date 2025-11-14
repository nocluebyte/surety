<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Sentinel;
use App\Models\SmtpConfiguration;

class MailTemplate extends MyModel
{

    use \Venturecraft\Revisionable\RevisionableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'mail_templates';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */

    protected $fillable = [
        'module_name', 'smtp_id', 'subject','message_body','is_active', 'ip', 'update_from_ip', 'created_by','updated_by'
    ];

    protected $dependency = array();

    protected static function boot()
    {
        parent::boot();
    }
    public function smtpDetail()
    {
        return $this->hasOne(SmtpConfiguration::class,'id', 'smtp_id');
    }
}
