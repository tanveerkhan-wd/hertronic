<?php

namespace App\models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable 
{
  use Notifiable;
  use SoftDeletes;

  protected $table = "Admin";
  // public $timestamps = false;

	protected $hidden = [
	    'password', 'remember_token',
	];

	protected $fillable = array('id', 'fkAdmCan', 'fkAdmCny', 'adm_Uid', 'adm_Name', 'adm_Photo', 'email', 'password', 'remember_token', 'adm_Title', 'adm_Phone', 'adm_GovId', 'adm_Gender', 'adm_DOB', 'adm_Address', 'email_verification_key','adm_Status', 'type', 'deleted_at');
}