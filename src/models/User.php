<?php

namespace Usyninis\Wucms;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	
	/*
		êàêèå ïîëÿ äîëæíû áûòü äîñòóïíû ïðè ìàññîâîì çàïîëíåíèè
	*/
	
	protected $fillable = array('first_name', 'last_name', 'email');
	
	/*	
		ñïèñîê çàïðåù¸ííûõ ê çàïîëíåíèþ ïîëåé
	*/
	
	protected $guarded = array('id', 'password');	
	
	
	public function getNameAttribute()
	{		 
		$name = trim(array_get($this->attributes,'first_name').' '.array_get($this->attributes,'last_name'));
		if(!empty($name)) return $name;
		return $this->attributes['email'];
	}
	public function setPasswordAttribute($value)
	{		 
		$this->attributes['password'] = \Hash::make($value);
	}

	/* public function toArray()
    {
        $array = parent::toArray();
        $array['roles'] = $this->roles;
        $array['role'] = $this->roles->first();
        $array['name'] = $this->name;
        return $array;
    } */

	public function roles()
	{
		return $this->belongsToMany('Usyninis\Wucms\Role')
			->orderBy('role_id', 'asc');
	}
	
	public function isRole($role)
	{
		
		if($this->roles)
			foreach($this->roles as $user_role)
				if($user_role->role==$role) return true;
				
		return false;
	}
	
	/* public function isAdmin()
	{
		$_admin_role_id = 1;
		$_admin_role_name = 'admin';
		if($this->roles)
			foreach($this->roles as $role)
				if($role->role==$_admin_role_name&&$role->id==$_admin_role_id) return true;
		return false;
	} */

	
}
