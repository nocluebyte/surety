<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Casts\Attribute;

Relation::MorphMap([
    'User'=>User::class,
    'Claim Examiner'=>ClaimExaminer::class
]);
class InvocationNotificationClaimExaminerLog extends MyModel
{
    use HasFactory;
    protected $fillable = [
        "id","invocation_notification_id","claim_examiner_assigned_date","claim_examiner_type","claim_examiner_id","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    // public function claimExaminer(){
    //     return $this->belongsTo(ClaimExaminer::class,'claim_examiner_id');
    // }

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function claimExaminer()
    {
        return $this->morphTo();
    }
    
    public function claimExaminerUserName() : Attribute   {
        return Attribute::make(
            get: function () {
            if ($this->claim_examiner_type === 'User' && $this->claimExaminer) {
                return $this->claimExaminer->full_name;
            }

            if ($this->claim_examiner_type === 'Claim Examiner' && $this->claimExaminer?->user) {
                return $this->claimExaminer->user->full_name;
            }

            return null;
        } 
        );
    }
}
