<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'states';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [
        "id","country_id","name","gst_code","is_active","ip","update_from_ip","created_by","updated_by","deleted_at","created_at","updated_at"
    ];

    protected $dependency = array(
        'InsuranceCompanies' => array('field' => 'state_id', 'model' => InsuranceCompanies::class),
        'UnderWriter' => array('field' => 'state_id', 'model' => UnderWriter::class),
        'Agent' => array('field' => 'state_id', 'model' => Agent::class),
        'Broker' => array('field' => 'state_id', 'model' => Broker::class),
        'Principle' => array('field' => 'state_id', 'model' => Principle::class),
        'Beneficiary' => array('field' => 'state_id', 'model' => Beneficiary::class),
        'Tender' => array('field' => 'state_id', 'model' => Tender::class),
        'Employee' => array('field' => 'state_id', 'model' => Employee::class),
        'RelationshipManager' => array('field' => 'state_id', 'model' => RelationshipManager::class),
        'BidBond' => array('field' => 'state_id', 'model' => BidBond::class),
        'AdvancePaymentBond' => array('field' => 'state_id', 'model' => AdvancePaymentBond::class),
        'RetentionBond' => array('field' => 'state_id', 'model' => RetentionBond::class),
        'MaintenanceBond' => array('field' => 'state_id', 'model' => MaintenanceBond::class),
    );

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
