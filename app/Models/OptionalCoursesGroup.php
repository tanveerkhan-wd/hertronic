<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionalCoursesGroup extends Model
{
    use SoftDeletes;
    protected $table = 'OptionalCoursesGroups';
    public $timestamps = false;

    protected $fillable = array('pkOcg', 'ocg_Uid', 'ocg_Name', 'ocg_Notes');
}
