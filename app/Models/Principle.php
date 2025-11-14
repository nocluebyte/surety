<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\morphMany; 
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Sentinel;
use Schema;

class Principle extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'principles';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","company_name","registration_no","principle_type_id","date_of_incorporation","inception_date","entity_type_id","staff_strength","are_you_blacklisted","address","city","pincode","country_id","state_id","website","pan_no","gst_no","venture_type","user_id","status","agency_id","agency_rating_id","rating_remarks","is_bank_guarantee_provided","circumstance_short_notes","is_action_against_proposer","action_details","contractor_failed_project_details","completed_rectification_details","performance_security_details","relevant_other_information","contractor_rating","uw_view_id","contractor_rating_date","last_balance_sheet_date","last_review_date","last_analysis_date","is_active","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    protected static function boot()
    {
        parent::boot();
    }
    public function dmsamend(): MorphTo{
        return $this->morphTo();
    }
    // public function dMS(): MorphMany{
    //     return $this->morphMany(DMS::class,'dmsamend');
    // }
    public  function  user(): BelongsTo{
        return $this->belongsTo(User::class,'user_id','id');
    }

    public  function  principleType(): BelongsTo{
        return $this->belongsTo(PrincipleType::class,'principle_type_id','id');
    }

    // protected function panNo(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn (string $value) => strtoupper($value),
    //     );
    // }

    protected $dependency = array(
        'User' => array('field' => 'id', 'model' => User::class),
    );

    public function scopePending(): morphMany
    {
        return $this->morphMany(Cases::class, 'casesable')->whereIn('status',['Pending','Transfer']);
    }
    public function cases(): morphMany
    {
        return $this->morphMany(Cases::class, 'casesable');
    }

    public function contractorLatestCase(): hasOne
    {
        return $this->hasOne(Cases::class, 'contractor_id')
            ->where('status','Completed')
                ->ofMany(['id'=>'max'],function($q){
                    $q->where('status','Completed');
                });
    }
    public function contractorItem()
    {
        return $this->morphMany(ContractorItem::class, 'contractoritemsable')->with('contractor');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->with('currency');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function updatedBy()
    {
        if (Schema::hasColumn($this->getTable(), 'updated_by')) {
            return $this->belongsTo('App\Models\User', 'updated_by', 'id');
        }
    }

    public function groupContractor()
    {
        return $this->hasOne(GroupContractor::class,'contractor_id')->with(['group','user']);
    }
    public function group()
    {
        return $this->hasOne(Group::class, 'contractor_id', 'id')->with('user');
    }
    public function typeOfEntity(){
        return $this->belongsTo(TypeOfEntity::class,'entity_type_id');
    }

    public function tradeSector(){
        return $this->morphMany(TradeSectorItem::class,'tradesectoritemsable')->with(['tradeSector']);
    }

     public function tradeSectorMain(){
        return $this->morphOne(TradeSectorItem::class,'tradesectoritemsable')
        ->where('is_main','Yes')->with(['tradeSector']);
    }

    public function contactDetail(){
        return $this->morphMany(ContactDetail::class,'contactdetailsable');
    }

    public function underwriterCasesLog(){
        return $this->morphMany(UnderwriterCasesLog::class, 'casesable');
    }

    public function bankingLimits(): MorphMany
    {
        return $this->morphMany(BankingLimit::class,'bankinglimitsable')->with('getBankingLimitCategoryName');
    }

    public function orderBookAndFutureProjects(): MorphMany
    {
        return $this->morphMany(OrderBookAndFutureProjects::class,'orderbookandfutureprojectsable');
    }

    public function projectTrackRecords(): MorphMany
    {
        return $this->morphMany(ProjectTrackRecords::class,'projecttrackrecordsable');
    }

    public function managementProfiles(): MorphMany
    {
        return $this->morphMany(ManagementProfiles::class,'managementprofilesable');
    }

    public  function  agency(): BelongsTo{
        return $this->belongsTo(Agency::class,'agency_id','id');
    }

    public  function  agencyRating(): BelongsTo{
        return $this->belongsTo(AgencyRating::class,'agency_rating_id','id');
    }

    public function dMS(): MorphMany
    {
        return $this->morphMany(DMS::class, 'dmsable');
    }

    public function agencyRatingDetails(): MorphMany
    {
        return $this->morphMany(AgencyRatingDetail::class,'agencyratingdetailsable')->with('agencyName');
    }

    public function analysis(){
        return $this->hasMany(Analysis::class,'contractor_id','id');
    }

      public function scopeRoleBasedScope($query,$user_role,$user_id){

        return $query->when(isset($user_role) && isset($user_id),function()use($query,$user_role,$user_id){
            
           switch ($user_role) {
            case 'contractor':
                $query->where('id',$user_id);
                break;
           }
        
        });
    }

    public function isGroup(): Attribute{
        return Attribute::make(
            get:fn()=> isset($this->group) && $this->group->count() > 0  ? true : false
        );
    }

    public function uwViewName(){
        return $this->hasOne(UwViewRating::class, 'id', 'uw_view_id');
    }

    public function invocationNotification(){
        return $this->hasMany(InvocationNotification::class,'contractor_id','id')->with(['beneficiary','contractor','tender', 'bondPoliciesIssue', 'recovery']);
    }

    public function recovery(){
        return $this->hasManyThrough(Recovery::class, InvocationNotification::class, 'contractor_id', 'invocation_notification_id', 'id');
    }

    public function letterOfAward(){
        return $this->hasMany(LetterOfAward::class,'contractor_id','id')->with('dMS', 'getBeneficiary', 'getContractor', 'getProjectDetails', 'getTender');
    }

    public function contractorAdverseInformation()
    {
        return $this->hasMany(AdverseInformation::class, 'contractor_id', 'id')->with('dMS');
    }

    public function contractorBlacklistInformation()
    {
        return $this->hasMany(Blacklist::class, 'contractor_id', 'id')->with('dMS');
    }
    public function markAsRead(){
        return $this->morphOne(MarkAsRead::class,'markable');
    }

}
