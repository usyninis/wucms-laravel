<?php

namespace Usyninis\Wucms;

use Illuminate\Database\Eloquent\Model as Eloquent;
	
class Role extends Eloquent
{

	public static $unguarded = true;
	
	public function users()
    {
        return $this->belongsToMany('User', 'role_user');
    }
	

}