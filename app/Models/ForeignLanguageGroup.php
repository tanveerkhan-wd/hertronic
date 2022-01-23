<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForeignLanguageGroup extends Model
{
    use SoftDeletes;
    protected $table = 'ForeignLanguageGroups';
    public $timestamps = false;

    protected $fillable = array('pkFon', 'fon_Uid', 'fon_Name', 'fon_Notes');
}
