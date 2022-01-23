<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentBehaviour extends Model
{
    use SoftDeletes;
    protected $table = 'StudentBehaviours';
    public $timestamps = false;


    protected $fillable = array('pkSbe', 'sbe_Uid', 'sbe_BehaviourName', 'sbe_Notes');
}
