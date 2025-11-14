<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends MyModel
{
    use HasFactory;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'types';
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    protected $fillable = [];
    protected $dates = ['deleted_at'];

    // protected $dependency = [
    //     'Category' => array('field' => 'type_id', 'model' => CategoryType::class),
    //     'ProductStructureItem' => array('field' => 'type_id', 'model' => ProductStructureItem::class)
    // ];

    // public function rmType()
    // {
    //     return $this->belongsTo(RawMaterial::class, 'id','type_id');
    // }
}
