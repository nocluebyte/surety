<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Sentinel;

class SmtpConfiguration extends MyModel
{

    use \Venturecraft\Revisionable\RevisionableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'smtp_configurations';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */

    protected $fillable = [
        'module_name', 'from_name', 'host_name','username','port','password','driver','encryption','subject', 'message_body','is_active', 'ip', 'update_from_ip', 'created_by','updated_by'
    ];

    protected $dependency = array();

    protected static function boot()
    {
        parent::boot();
    }
}
