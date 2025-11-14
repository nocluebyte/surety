<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphTo;

Relation::MorphMap([
    'BidBond'=>BidBond::class,
    'PerformanceBond'=>PerformanceBond::class,
    'AdvancePaymentBond'=>AdvancePaymentBond::class,
    'RetentionBond'=>RetentionBond::class,
    'MaintenanceBond'=>MaintenanceBond::class,
]);

class Bonds extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'bonds';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","bondsable_type","bondsable_id","is_amendment","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    public function bondsable(): MorphTo
    {
        return $this->morphTo();
    }
}
