<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExtracurricuralActivityType extends Model
{
    use SoftDeletes;
    protected $table = 'ExtracurricuralActivityTypes';
    public $timestamps = false;


    protected $fillable = array('pkSat', 'sat_Uid', 'sat_StudentExtracurricuralActivityName', 'sat_Notes');
}
