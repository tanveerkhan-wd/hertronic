<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentDisciplineMeasureType extends Model
{
    use SoftDeletes;
    protected $table = 'StudentDisciplineMeasureTypes';
    public $timestamps = false;


    protected $fillable = array('pkSmt', 'smt_Uid', 'smt_DisciplineMeasureName', 'smt_Notes');
}
