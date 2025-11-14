<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'project_details';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","code","beneficiary_id","project_name","project_description","project_value","type_of_project","project_start_date","project_end_date","period_of_project","is_active","created_by","updated_by","ip","update_from_ip","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'Tender' => array('field' => 'project_details', 'model' => Tender::class),
        'Proposal' => array('field' => 'project_details', 'model' => Proposal::class),
    );

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'type_of_project');
    }

    public function scopeRoleBasedScope($query,$user_role,$user_id){

        return $query->when(isset($user_role) && isset($user_id),function()use($query,$user_role,$user_id){
            
           switch ($user_role) {
            case 'beneficiary':
                $query->where('project_details.beneficiary_id',$user_id);
                break;
           }
        
        });
    }

    public function markAsRead(){
        return $this->morphOne(MarkAsRead::class,'markable');
    }

}
