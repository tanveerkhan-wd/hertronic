<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationPeriod extends Model
{
    use SoftDeletes;
    protected $table = 'EducationPeriods';
    public $timestamps = false;

    public function classCreation()
    {
        return $this->hasMany('App\Models\ClassCreation', 'fkClrEdp', 'pkEdp');
    }

    protected $fillable = array('pkEdp', 'edp_Uid', 'edp_EducationPeriodName', 'edp_EducationPeriodNameAdjective');
}
