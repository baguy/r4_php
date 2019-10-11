<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use RemindableTrait, SoftDeletingTrait, UserTrait;

  const DEFAULT_PASSWORD = 'password1!';

  const SUSPENSION_TIME  = '+15 minutes';

	protected $table       = 'users';

	protected $hidden      = array('password', 'remember_token');

  protected $fillable    = array('name', 'email', 'nickname', 'avatar');

  protected $guarded     = array('password');

  public function roles() {
    return $this->belongsToMany('Role', 'users_roles');
  }

  public function loggers() {
    return $this->hasMany('Logger');
  }

  public function throttle() {
    return $this->hasOne('Throttle');
  }

	public function comments() {
		return $this->hasMany('Comentario');
	}

  public function hasRole($name) {

    foreach ($this->roles as $role) {

      if ($role->name === $name) return true;
    }

    return false;
  }

  public function minRole() {

    foreach ($this->roles as $role) {

      if ($role->id === $this->roles->min('id')) return $role;
    }
  }

  public function userIsAuth($user) {

    return $user->id === Auth::user()->id; // User must not be null
  }

  public function userMinRoleIsLessOrEqualThanAuthMinRole($user) {

    return $user->minRole()->id <= Auth::user()->minRole()->id; // User must not be null
  }
}
