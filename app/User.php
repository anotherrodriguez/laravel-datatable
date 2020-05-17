<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function isSuperAdmin()
    {
        return $this->role->name === 'super_admin';
    }

    public function isAdmin()
    {
        return $this->role->name === 'admin' | $this->isSuperAdmin();
    }

    public function isUser()
    {
        return $this->role->name === 'super_admin' | $this->isAdmin() | $this->isSuperAdmin();
    }
}
