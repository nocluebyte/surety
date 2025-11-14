<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Sentinel;

Relation::MorphMap([
    'Principle'=>Principle::class,
    'Beneficiary'=>Beneficiary::class,
    'BidBond'=>BidBond::class,
    'Proposal'=>Proposal::class,
    'PerformanceBond'=>PerformanceBond::class,
    'Tender'=>Tender::class,
    'BankingLimits'=>BankingLimit::class,
    'OrderBookAndFutureProjects'=>OrderBookAndFutureProjects::class,
    'ProjectTrackRecords'=>ProjectTrackRecords::class,
    'ManagementProfiles'=>ManagementProfiles::class,
    'BondPoliciesIssueChecklist'=>BondPoliciesIssueChecklist::class,
    'AdvancePaymentBond'=>AdvancePaymentBond::class,
    'RetentionBond'=>RetentionBond::class,
    'MaintenanceBond'=>MaintenanceBond::class,
    'InvocationNotification'=>InvocationNotification::class,
    'AdverseInformation'=>AdverseInformation::class,
    'Blacklist'=>Blacklist::class,
    'Employee'=>Employee::class,
    'BondProgress'=>BondProgress::class,
    'BondClosure'=>BondClosure::class,
    'BondCancel'=>BondCancel::class,
    'LetterOfAward'=>LetterOfAward::class,
    'Endorsement'=>Endorsement::class,
    'InvocationClaims'=>InvocationClaims::class,
    'BondPoliciesIssue'=>BondPoliciesIssue::class,
    'BondForeClosure'=>BondForeClosure::class,
    'BondCancellation'=>BondCancellation::class,
    'Nbi'=>Nbi::class
]);

class DMS extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'dms';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","file_source_id","document_type_id","file_name","attachment","attachment_type","dmsable_type","dmsable_id","is_amendment","final_submission","document_specific_type","checklist_bond_type","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at","dmsamend_type","dmsamend_id"
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function dmstable(): MorphTo
    {
        return $this->morphTo();
    }
    public function dmsamend(): MorphTo
    {
        return $this->morphTo();
    }


    public function scopeAttachmentInsideDmsTab(Builder $query,$type, $id): Builder{
        return $query->whereIn('dmsable_type',[$type, 'Other', 'InvocationNotification'])->where('id',$id);
    }

    public function documentType(){
        return $this->belongsTo(DocumentType::class,'document_type_id');
    }

    public function fileSource(){
        return $this->belongsTo(FileSource::class,'file_source_id');
    }
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function Comment(){
        return $this->hasMany(DmsComment::class,'dms_id');
    }
    public function nbi(){
        return $this->hasOne(Nbi::class,'id','dmsable_id');
    }
}
