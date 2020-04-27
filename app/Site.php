<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

     /**
     * Get the departments for the site.
     */
    public function department()
    {
        return $this->hasMany('App\Department');
    }
}
