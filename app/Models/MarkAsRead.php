<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::enforceMorphMap([
    'Principle'=>Principle::class,
    'Cases'=>Cases::class,
    'Proposal'=>Proposal::class,
    'Beneficiary'=>Beneficiary::class,
    'ProjectDetail'=>ProjectDetail::class
]);
class MarkAsRead extends MyModel
{
    use HasFactory;

    public function markable(){
        return $this->morphTo();
    }
}
