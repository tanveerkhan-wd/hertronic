<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralPurposeGroup extends Model
{
    use SoftDeletes;
    protected $table = 'GeneralPurposeGroups';
    public $timestamps = false;

    protected $fillable = array('pkGpg', 'gpg_Uid', 'gpg_Name', 'gpg_Notes');
}
